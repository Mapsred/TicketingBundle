<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 13/07/2017
 * Time: 18:20
 */

namespace Maps_red\TicketingBundle\Controller;

use Maps_red\TicketingBundle\Manager\TicketManager;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class TicketingRatingController extends Controller
{
    /** @var TicketManager $ticketManager */
    private $ticketManager;

    /**
     * TicketingRatingController constructor.
     * @param TicketManager $ticketManager
     */
    public function __construct(TicketManager $ticketManager)
    {
        $this->ticketManager = $ticketManager;
    }

    /**
     * @Route("/vote", name="ticketing_ajax_rating_add", options={"expose"=true})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addRatingAction(Request $request)
    {
        if (!$request->request->has('rating') || !$request->request->has('ticket') || !$request->isXmlHttpRequest()) {
            return $this->json('error', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if  (null === $ticket = $this->ticketManager->getRepository()->find($request->request->get("ticket"))) {
            return $this->json('error', JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->ticketManager->handleRating($ticket, $request->request->get('rating'));

        $content = $this->getRating($ticket->getId())->getContent();

        return $this->json(['success' => "Merci d'avoir voté", 'content' => $content]);
    }

    /**
     * @param int $ticket
     * @param bool $readonly
     * @return Response
     */
    public function getRating(int $ticket, $readonly = false)
    {
        $ticket = $this->ticketManager->getRepository()->find($ticket);

        return $this->render("@Ticketing/ticketing/rating/rating.html.twig", [
            'integer' => $ticket->getRating(),
            'readonly' => $readonly
        ]);
    }

    /**
     * @param integer $user_id
     * @return Response
     */
    public function getUserRating($user_id)
    {
        $user = $this->getDoctrine()->getRepository(UserInterface::class)->find($user_id);
        $rating = $this->ticketManager->getRepository()->findUserAvgRating($user);


        return $this->render("@Ticketing/ticketing/rating/rating.html.twig", ['integer' => round($rating)]);
    }

    /**
     * @param integer $user_id
     * @return Response
     */
    public function getUserClosedTickets($user_id)
    {
        $user = $this->getDoctrine()->getRepository(UserInterface::class)->find($user_id);
        $rating = $this->ticketManager->getRepository()->countBySpecificUserAndStatus($user, "closed");

        return $this->render("@Ticketing/ticketing/rating/closed.html.twig", ['integer' => round($rating)]);
    }

    /**
     * @param integer $rating
     * @return Response
     */
    public function renderRating($rating)
    {
        return $this->render("@Ticketing/ticketing/rating/rating.html.twig", ['integer' => round($rating), 'readonly' => true]);
    }
}
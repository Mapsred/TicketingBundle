<?php

namespace Maps_red\TicketingBundle\Controller;

use Maps_red\TicketingBundle\Form\TicketCloseForm;
use Maps_red\TicketingBundle\Form\TicketCommentForm;
use Maps_red\TicketingBundle\Manager\TicketCommentManager;
use Maps_red\TicketingBundle\Manager\TicketStatusManager;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maps_red\TicketingBundle\Form\TicketForm;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Translation\TranslatorInterface;

class TicketingController extends Controller
{
    /** @var array $ticketingTemplates */
    private $ticketingTemplates;

    /** @var TranslatorInterface $translator */
    private $translator;

    /**
     * TicketingController constructor.
     * @param array $ticketingTemplates
     * @param TranslatorInterface $translator
     */
    public function __construct(array $ticketingTemplates, TranslatorInterface $translator)
    {
        $this->ticketingTemplates = $ticketingTemplates;
        $this->translator = $translator;
    }

    /**
     * @Route("/list", name="ticketing_list")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param TicketStatusManager $ticketStatusManager
     * @return Response
     */
    public function listTickets(TicketStatusManager $ticketStatusManager)
    {
        return $this->render($this->ticketingTemplates['list'], [
            'status_list' => $ticketStatusManager->getRepository()->findAll()
        ]);
    }

    /**
     * @Route("/perso", name="ticketing_perso")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param TicketStatusManager $ticketStatusManager
     * @return Response
     */
    public function persoTickets(TicketStatusManager $ticketStatusManager)
    {
        return $this->render($this->ticketingTemplates['perso'], [
            'status_list' => $ticketStatusManager->getRepository()->findAll()
        ]);
    }

    /**
     * @Route("/new", name="ticketing_new", methods="GET|POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param TicketManager $ticketManager
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addTicket(Request $request, TicketManager $ticketManager): Response
    {
        $ticket = $ticketManager->newClass();
        $user = $this->getUser();
        $ticketForm = $this->createForm(TicketForm::class, $ticket);
        $ticketForm->handleRequest($request);

        if ($ticketForm->isSubmitted() && $ticketForm->isValid()) {
            $ticketManager->createTicket($user, $ticket);
            $this->addFlash('success', 'The ticket is online !');

            return $this->redirectToRoute('ticketing_list');
        }

        return $this->render($this->ticketingTemplates['new'], [
            'form' => $ticketForm->createView(),
        ]);
    }

    /**
     * @Route("/detail/{id}", name="ticketing_detail", options={"expose": "true"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param TicketInterface $ticket
     * @param TicketManager $ticketManager
     * @param TicketCommentManager $ticketCommentManager
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function detail(Request $request, TicketInterface $ticket, TicketManager $ticketManager, TicketCommentManager $ticketCommentManager)
    {
        if (!$ticketManager->isTicketGranted($ticket, $this->getUser())) {
            $this->addFlash("warning", $this->trans('restricted_ticket'));

            return $this->redirectToRoute("ticketing_perso");
        }

        $comment = $ticketCommentManager->newClass();
        $commentForm = $this->createForm(TicketCommentForm::class, $comment);
        $closeForm = $this->createForm(TicketCloseForm::class, $ticket);

        $commentForm->handleRequest($request);
        $closeForm->handleRequest($request);

        $comments = $ticketCommentManager->getTicketComments($ticket);
        $route = $this->redirectToRoute("ticketing_detail", ['id' => $ticket->getId()]);
        $isAuthorOrGranted = $ticketManager->isAuthorOrGranted($ticket, $this->getUser());
        $isGranted = $ticketManager->isPrivateTicketAuthorized();

        //Current user manage this ticket
        if ($request->request->has("manage") && $isGranted) {
            $ticketManager->handleManageAction($ticket, $this->getUser());
            $this->addFlash('info', $this->trans('ticket_assignated'));

            return $route;
        }

        //Current user open again this ticket
        if ($request->request->has("open") && $isGranted) {
            $ticketManager->handleOpenAction($ticket);
            $this->addFlash('success', $this->trans('ticket_reopened'));

            return $route;
        }

        if ($request->request->has("public") && $isAuthorOrGranted) {
            $isPublic = (int)$request->request->get("public");
            $ticketManager->handlePublicStatusAction($ticket, $this->getUser(), $isPublic);
            $this->addFlash('success', sprintf('Le ticket a bien été passé en %s', $isPublic ? "public" : "privé"));

            return $route;
        }


        //Current user add a comment to this ticket
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $ticketManager->handleCommentAction($ticket, $this->getUser(), $comment);
            $this->addFlash('success', 'Le commentaire a bien été ajouté');

            return $route;
        }

        //Current use close the ticket
        if ($closeForm->isSubmitted() && $closeForm->isValid() && $isAuthorOrGranted) {
            $ticketManager->handleCloseAction($ticket, $this->getUser());
            $this->addFlash('success', 'Le ticket a bien été fermé');

            return $route;
        }


        return $this->render($this->ticketingTemplates['detail'], [
            'ticket' => $ticket,
            'form' => $commentForm->createView(),
            'close_form' => $closeForm->createView(),
            'isAuthorOrGranted' => $isAuthorOrGranted,
            'isGranted' => $isGranted,
            'comments' => $comments
        ]);
    }

    /**
     * @param $id
     * @param array $parameters
     * @return string
     */
    private function trans($id, array $parameters = [])
    {
        return $this->translator->trans($id, $parameters, 'TicketingBundle');
    }
}
<?php
namespace Maps_red\TicketingBundle\Controller;

use Maps_red\TicketingBundle\Entity\Ticket;
use Maps_red\TicketingBundle\Manager\TicketCategoryManager;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ajax")
 */
class TicketingAjaxController extends Controller
{
    /**
     * @Route("/{status}/{type}", name="ticketing_ajax_datatable", options={"expose": "true"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Method({"GET"})
     * @param Request $request
     * @param TicketManager $ticketManager
     * @param string $status
     * @param string $type
     * @return Response
     */
    public function dataTableProcessing(Request $request, TicketManager $ticketManager, string $status, string $type)
    {
        $results = $ticketManager->handleDataTable($request->query->all(), $status, $type, $this->getUser());

        return $this->json([
            'draw' => $request->query->getInt('draw'),
            'recordsTotal' => $ticketManager->getRepository()->count([]),
            'recordsFiltered' => $results['count'],
            'data' => array_map(function (Ticket $ticket) use ($ticketManager) {
                return array_values($ticketManager->toArray($ticket));
            }, $results['data']),
        ]);
    }

    /**
     * @Route("/categories", name="ticketing_ajax_categories", options={"expose"=true})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param TicketCategoryManager $ticketCategoryManager
     * @return Response
     */
    public function getCategories(Request $request, TicketCategoryManager $ticketCategoryManager)
    {
        if ($request->query->has("cat")) {
            return $this->json(['categories' => $ticketCategoryManager->getRepository()->findAllCategories()]);
        }

        return $this->json([], Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("/categories/change", name="ticketing_ajax_cat_change", options={"expose"=true})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Method({"POST"})
     * @param Request $request
     * @param TicketManager $ticketManager
     * @param TicketCategoryManager $ticketCategoryManager
     * @return Response
     */
    public function setCategories(Request $request, TicketManager $ticketManager, TicketCategoryManager $ticketCategoryManager)
    {
        if ($request->request->has("cat") && $request->request->has("id")) {
            $ticket = $ticketManager->getRepository()->find($request->request->get('id'));
            if ($ticketManager->isAuthorOrGranted($ticket, $this->getUser())) {
                $category = $request->request->get("cat");
                if ($ticket && null !== $category = $ticketCategoryManager->getRepository()->findOneBy(['value' => $category])) {
                    $ticket->setCategory($category);
                    $ticketManager->persistAndFlush($ticket);
                }

                return $this->json(['validated' => true]);
            }
        }

        return $this->json([], Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("/update_ticket_status", name="ticketing_ajax_status_update", options={"expose"=true})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Method({"POST"})
     * @param Request $request
     * @param TicketManager $ticketManager
     * @return Response
     */
    public function updateTicketStatusAction(Request $request, TicketManager $ticketManager)
    {
        if ($request->request->has("id") && $ticketManager->isPrivateTicketAuthorized()) {
            $ticket = $ticketManager->getRepository()->find($request->request->get("id"));
            $ticketManager->handleStatusChange($ticket);

            return $this->json(["message" => "success"]);
        }

        return $this->json([], Response::HTTP_FORBIDDEN);
    }
}

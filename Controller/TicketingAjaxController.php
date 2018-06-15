<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 14/06/2018
 * Time: 23:42
 */

namespace Maps_red\TicketingBundle\Controller;

use Maps_red\TicketingBundle\Entity\Ticket;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ajax")
 */
class TicketingAjaxController extends Controller
{
    /**
     * @Route("/{status}/{type}", name="data_table", options={"expose": "true"})
     * @param Request $request
     * @param TicketManager $ticketManager
     * @param string $status
     * @param string $type
     * @return Response
     */
    public function dataTableProcessing(Request $request, TicketManager $ticketManager, string $status, string $type)
    {
        $results = $ticketManager->handleDataTable($request->query->all(), $status, $type);

        return $this->json([
            'draw' =>$request->query->getInt('draw'),
            'recordsTotal' => $ticketManager->getRepository()->count([]),
            'recordsFiltered' => $results['count'],
            'data' => array_map(function (Ticket $ticket) use($ticketManager) {
                return array_values($ticketManager->toArray($ticket));
            }, $results['data']),
        ]);
    }
}
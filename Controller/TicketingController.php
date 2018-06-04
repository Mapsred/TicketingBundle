<?php

namespace Maps_red\TicketingBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Maps_red\TicketingBundle\Entity\Ticket;
use Maps_red\TicketingBundle\Form\TicketForm;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketingController extends Controller
{
    /**
     * @Route("/allTicketing", name="all_ticketing")
     */
    public function index()
    {
        return $this->render('@Ticketing/ticketing/index.html.twig', [
        ]);
    }

    /**
     * @Route("/nouveau", name="new_ticketing", methods="GET|POST")
     * @param Request $request
     * @param TicketManager $ticketManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addTicket(Request $request, TicketManager $ticketManager): \Symfony\Component\HttpFoundation\Response
    {
        $ticket = new Ticket();
        $user = $this->getUser();
        $ticketForm = $this->createForm(TicketForm::class);
        $ticketForm->handleRequest($request);

        if($ticketForm->isSubmitted() && $ticketForm->isValid()){
            $ticketManager->createTicket($user, $ticket);
            $this->addFlash('success', 'The ticket is online !');
            return $this->render('@Ticketing/ticketing/index.html.twig', [
            ]);
        }

        return $this->render('@Ticketing/ticketing/new.html.twig', [
            'form' => $ticketForm->createView(),
        ]);
    }

    /**
     * @Route("/detail/{id}", name="ticketing_detail")
     * @param Ticket $ticket
     */
    public function detail(Ticket $ticket)
    {
        var_dump($ticket);
    }
}
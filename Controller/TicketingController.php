<?php

namespace Maps_red\TicketingBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/nouveau", name="new_ticketing")
     */
    public function addTicket()
    {
        return $this->render('@Ticketing/ticketing/new.html.twig', [
        ]);
    }
}
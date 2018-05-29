<?php

namespace Maps_red\TicketingBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketingController extends Controller
{
    /**
     * @Route("/nouveau", name="new_ticketing")
     */
    public function index()
    {
        return $this->render('@Ticketing/ticketing/index.html.twig', [
            'controller_name' => 'Test',
        ]);
    }
}
<?php

namespace Maps_red\TicketingBundle\Controller;

use Maps_red\TicketingBundle\Manager\TicketStatusManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maps_red\TicketingBundle\Entity\Ticket;
use Maps_red\TicketingBundle\Form\TicketForm;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketingController extends Controller
{
    /**
     * @Route("/perso", name="ticketing_perso")
     * @param TicketStatusManager $ticketStatusManager
     * @return Response
     */
    public function persoTicketsAction(TicketStatusManager $ticketStatusManager)
    {
        return $this->render("@Ticketing/ticketing/personal_page.html.twig", [
            'status_list' => $ticketStatusManager->getRepository()->findAll()
        ]);
    }

    /**
     * @Route("/all", name="ticketing_all")
     */
    public function index()
    {
        return $this->render('@Ticketing/ticketing/index.html.twig', [
        ]);
    }

    /**
     * @Route("/new", name="ticketing_new", methods="GET|POST")
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

            return $this->redirectToRoute('ticketing_all');
        }

        return $this->render('@Ticketing/ticketing/new.html.twig', [
            'form' => $ticketForm->createView(),
        ]);
    }

    /**
     * @Route("/detail/{id}", name="ticketing_detail", options={"expose": "true"})
     * @param Ticket $ticket
     * @param TicketManager $ticketManager
     * @return RedirectResponse|Response
     */
    public function detail(Ticket $ticket, TicketManager $ticketManager)
    {
        if (!$ticketManager->isTicketGranted($ticket, $this->getUser())) {
            $this->addFlash("warning", "Ce ticket appartient à une catégorie restreinte, vous ne disposez pas des 
            permissions suffisantes pour l'afficher");

            return $this->redirectToRoute("ticketing_perso");
        }

//        $comment = new Comment();
//        $commentForm = $this->createForm(CreateCommentForm::class, $comment);
//        $closeForm = $this->createForm(CloseTicket::class, $ticket);

//        $commentForm->handleRequest($request);
//        $closeForm->handleRequest($request);

//        $this->get(HistoryManager::class)->setSeen($this->getUser(), $ticket);

//        $route = $this->redirectToRoute("ticket_detail", ['id' => $ticket->getId()]);
//        $isModeratorOrAuthor = $this->isGranted("ROLE_MODERATEUR_JUNIOR") || $this->getUser() === $ticket->getAuthor();



        return $this->render("@Ticketing/ticketing/detail_page.html.twig", [
            'ticket' => $ticket,
//            'form' => $commentForm->createView(),
//            'close_form' => $closeForm->createView(),
        ]);
    }
}
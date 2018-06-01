<?php

namespace Maps_red\TicketingBundle\EventSubscriber;

use Maps_red\TicketingBundle\Event\TicketSeenEvent;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestSubscriber implements EventSubscriberInterface
{
    /** @var TicketManager $ticketManager */
    private $ticketManager;

    /** @var EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    /**
     * RequestSubscriber constructor.
     * @param TicketManager $ticketManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(TicketManager $ticketManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->ticketManager = $ticketManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        // don't do anything if it's not the master request
        if (!$event->isMasterRequest()) {
            return;
        }

        if ($event->getRequest()->get("_route") === "ticketing_detail") {
            /** @var TicketInterface $ticket */
            $ticket = $this->ticketManager->getRepository()->find($event->getRequest()->attributes->get('id'));
            $event = new TicketSeenEvent($ticket);

            $this->eventDispatcher->dispatch(TicketSeenEvent::NAME, $event);
        }
    }


}

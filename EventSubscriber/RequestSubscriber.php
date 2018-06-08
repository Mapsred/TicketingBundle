<?php

namespace Maps_red\TicketingBundle\EventSubscriber;

use Maps_red\TicketingBundle\Event\TicketSeenEvent;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Maps_red\TicketingBundle\Utils\TicketingHelper;

class RequestSubscriber implements EventSubscriberInterface
{
    /** @var TicketManager $ticketManager */
    private $ticketManager;

    /** @var EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    /** @var TicketingHelper $ticketingHelper */
    private $ticketingHelper;

    /** @var string $restrictedTicketsRole */
    private $restrictedTicketsRole;

    /**
     * RequestSubscriber constructor.
     * @param TicketManager $ticketManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param TicketingHelper $ticketingHelper
     * @param string $restrictedTicketsRole
     */
    public function __construct(TicketManager $ticketManager, EventDispatcherInterface $eventDispatcher, TicketingHelper $ticketingHelper, string $restrictedTicketsRole)
    {
        $this->ticketManager = $ticketManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->restrictedTicketsRole = $restrictedTicketsRole;
        $this->ticketingHelper = $ticketingHelper;
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

        $controller = explode("::", $event->getRequest()->attributes->get('_controller'))[0];
        if ($controller === 'Maps_red\TicketingBundle\Controller\TicketingController') {
            $user = $this->ticketingHelper->getUser();
            if (null !== $user && $this->ticketingHelper->isGranted($this->restrictedTicketsRole)) {
                return;
            }

            throw new AccessDeniedHttpException();
        }

        if ($event->getRequest()->get("_route") === "ticketing_detail") {
            /** @var TicketInterface $ticket */
            $ticket = $this->ticketManager->getRepository()->find($event->getRequest()->attributes->get('id'));
            $event = new TicketSeenEvent($ticket);

            $this->eventDispatcher->dispatch(TicketSeenEvent::NAME, $event);
        }
    }


}

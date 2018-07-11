<?php

namespace Maps_red\TicketingBundle\EventSubscriber;

use Maps_red\TicketingBundle\Event\TicketSeenEvent;
use Maps_red\TicketingBundle\Manager\TicketManager;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class RequestSubscriber implements EventSubscriberInterface
{
    /** @var TicketManager $ticketManager */
    private $ticketManager;

    /** @var EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    /** @var string $restrictedTicketsRole */
    private $restrictedTicketsRole;

    /** @var Security $security */
    private $security;

    /**
     * RequestSubscriber constructor.
     * @param TicketManager $ticketManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param Security $security
     * @param string $restrictedTicketsRole
     */
    public function __construct(TicketManager $ticketManager, EventDispatcherInterface $eventDispatcher, Security $security, string $restrictedTicketsRole)
    {
        $this->ticketManager = $ticketManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->restrictedTicketsRole = $restrictedTicketsRole;
        $this->security = $security;
    }

    /**
     * @return array
     */
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
            $ticketSeenEvent = new TicketSeenEvent($ticket);

            $this->eventDispatcher->dispatch(TicketSeenEvent::NAME, $ticketSeenEvent);

            $event->getRequest()->attributes->set('ticket', $ticket);
        }

        $controller = explode("::", $event->getRequest()->attributes->get('_controller'))[0];
        if ($controller === 'Maps_red\TicketingBundle\Controller\TicketingController') {
            $user = $this->security->getUser();
            if (null !== $user && $this->security->isGranted($this->restrictedTicketsRole)) {
                return;
            }

            throw new AuthenticationException();
        }
    }
}

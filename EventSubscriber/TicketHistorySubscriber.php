<?php

namespace Maps_red\TicketingBundle\EventSubscriber;

use Maps_red\TicketingBundle\Event\TicketSeenEvent;
use Maps_red\TicketingBundle\Event\TicketUnseenEvent;
use Maps_red\TicketingBundle\Manager\TicketHistoryManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class TicketHistorySubscriber
 * @package Maps_red\TicketingBundle\EventSubscriber
 */
class TicketHistorySubscriber implements EventSubscriberInterface
{
    /** @var Security $security */
    private $security;

    /** @var TicketHistoryManager $ticketHistoryManager */
    private $ticketHistoryManager;

    /** @var bool $enableHistory */
    private $enableHistory;

    /**
     * RequestSubscriber constructor.
     * @param Security $security
     * @param TicketHistoryManager $ticketHistoryManager
     * @param bool $enableHistory
     */
    public function __construct(Security $security, TicketHistoryManager $ticketHistoryManager, bool $enableHistory)
    {
        $this->security = $security;
        $this->ticketHistoryManager = $ticketHistoryManager;
        $this->enableHistory = $enableHistory;
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            TicketSeenEvent::NAME => 'onTicketingSeen',
            TicketUnseenEvent::NAME => 'onTicketingUnseen',
        ];
    }

    /**
     * @param TicketSeenEvent $event
     */
    public function onTicketingSeen(TicketSeenEvent $event)
    {
        if ($this->enableHistory && null !== $user = $this->security->getUser()) {
            $this->ticketHistoryManager->setSeen($user, $event->getTicket());
        }
    }

    /**
     * @param TicketUnseenEvent $event
     */
    public function onTicketingUnseen(TicketUnseenEvent $event)
    {
        if ($this->enableHistory && null !== $user = $this->security->getUser()) {
            $this->ticketHistoryManager->setUnseen($user, $event->getTicket());
        }
    }
}

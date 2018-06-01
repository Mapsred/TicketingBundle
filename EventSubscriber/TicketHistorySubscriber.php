<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 01/06/2018
 * Time: 21:20
 */

namespace Maps_red\TicketingBundle\EventSubscriber;

use Maps_red\TicketingBundle\Event\TicketSeenEvent;
use Maps_red\TicketingBundle\Event\TicketUnseenEvent;
use Maps_red\TicketingBundle\Manager\TicketHistoryManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TicketHistorySubscriber
 * @package Maps_red\TicketingBundle\EventSubscriber
 */
class TicketHistorySubscriber implements EventSubscriberInterface
{
    /** @var TokenStorageInterface $tokenStorage */
    private $tokenStorage;

    /** @var TicketHistoryManager $ticketHistoryManager */
    private $ticketHistoryManager;

    /**
     * RequestSubscriber constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param TicketHistoryManager $ticketHistoryManager
     */
    public function __construct(TokenStorageInterface $tokenStorage, TicketHistoryManager $ticketHistoryManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->ticketHistoryManager = $ticketHistoryManager;
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
        if (null !== $user = $this->getUser()) {
            $this->ticketHistoryManager->setSeen($user, $event->getTicket());
        }
    }

    /**
     * @param TicketUnseenEvent $event
     */
    public function onTicketingUnseen(TicketUnseenEvent $event)
    {
        if (null !== $user = $this->getUser()) {
            $this->ticketHistoryManager->setUnseen($user, $event->getTicket());
        }
    }

    /**
     * @return UserInterface|null
     */
    private function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 01/06/2018
 * Time: 21:20
 */

namespace Maps_red\TicketingBundle\EventSubscriber;

use Maps_red\TicketingBundle\Event\TicketStatusHistoryEvent;
use Maps_red\TicketingBundle\Manager\TicketStatusHistoryManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class TicketStatusHistorySubscriber
 * @package Maps_red\TicketingBundle\EventSubscriber
 */
class TicketStatusHistorySubscriber implements EventSubscriberInterface
{
    /** @var Security $security */
    private $security;

    /** @var TicketStatusHistoryManager $ticketStatusHistoryManager */
    private $ticketStatusHistoryManager;

    /**
     * RequestSubscriber constructor.
     * @param Security $security
     * @param TicketStatusHistoryManager $ticketStatusHistoryManager
     */
    public function __construct(Security $security, TicketStatusHistoryManager $ticketStatusHistoryManager)
    {
        $this->security = $security;
        $this->ticketStatusHistoryManager = $ticketStatusHistoryManager;
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            TicketStatusHistoryEvent::NAME => 'onTicketStatusChange',
        ];
    }

    /**
     * @param TicketStatusHistoryEvent $event
     * @throws \Doctrine\ORM\ORMException
     */
    public function onTicketStatusChange(TicketStatusHistoryEvent $event)
    {
        $entity = $this->ticketStatusHistoryManager->newClass();
        $entity->setAuthor($this->security->getUser())
            ->setTicket($event->getTicket())
            ->setStatus($event->getTicketStatus());

        $this->ticketStatusHistoryManager->getManager()->persist($entity);
    }

}
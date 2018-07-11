<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Model\TicketStatusHistoryInterface;
use Maps_red\TicketingBundle\Repository\TicketStatusHistoryRepository;

/**
 * @method TicketStatusHistoryInterface newClass()
 * @method TicketStatusHistoryRepository getRepository()()
 */
class TicketStatusHistoryManager extends AbstractManager
{
    /**
     * TicketStatusManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     */
    public function __construct(EntityManagerInterface $manager, string $class)
    {
        parent::__construct($manager, $class);
    }

    /**
     * @param TicketInterface $ticket
     * @return ArrayCollection
     */
    public function getTicketStatusHistory(TicketInterface $ticket)
    {
        return new ArrayCollection($this->getRepository()->getTicketStatusHistory($ticket));
    }
}

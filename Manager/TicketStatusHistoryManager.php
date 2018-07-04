<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;

class TicketStatusHistoryManager extends AbstractManager
{
    /** @var array $ticketStatusHistory */
    private $ticketStatusHistory;

    /**
     * TicketStatusManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param array $ticketStatusHistory
     */
    public function __construct(EntityManagerInterface $manager, string $class, array $ticketStatusHistory)
    {
        parent::__construct($manager, $class);
        $this->ticketStatusHistory = $ticketStatusHistory;
    }

}
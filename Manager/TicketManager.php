<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;

class TicketManager extends AbstractManager
{
    /** @var bool $enableHistory */
    private $enableHistory;

    /**
     * TicketManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param bool $enableHistory
     */
    public function __construct(EntityManagerInterface $manager, string $class, bool $enableHistory)
    {
        $this->enableHistory = $enableHistory;
        parent::__construct($manager, $class);
    }
}
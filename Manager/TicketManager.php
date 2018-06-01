<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;

class TicketManager extends AbstractManager
{
    /** @var string $defaultStatusName */
    private $defaultStatusName;

    /** @var bool $enableHistory */
    private $enableHistory;

    /**
     * TicketManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param string $defaultStatusName
     * @param bool $enableHistory
     */
    public function __construct(EntityManagerInterface $manager, string $class, string $defaultStatusName, bool $enableHistory)
    {
        $this->defaultStatusName = $defaultStatusName;
        $this->enableHistory = $enableHistory;
        parent::__construct($manager, $class);
    }
}
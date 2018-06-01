<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;

class TicketCategoryManager extends AbstractManager
{
    /** @var string $defaultStatusName */
    private $defaultStatusName;

    /**
     * TicketCategoryManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param string $defaultStatusName
     */
    public function __construct(EntityManagerInterface $manager, string $class, string $defaultStatusName)
    {
        $this->defaultStatusName = $defaultStatusName;
        parent::__construct($manager, $class);
    }
}
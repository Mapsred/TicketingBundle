<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;

class TicketStatusManager extends AbstractManager
{
    /** @var string $defaultStatusName */
    private $defaultStatusName;

    /**
     * TicketStatusManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param string $defaultStatusName
     */
    public function __construct(EntityManagerInterface $manager, string $class, string $defaultStatusName)
    {
        parent::__construct($manager, $class);
        $this->defaultStatusName = $defaultStatusName;
    }

    /**
     * @return TicketStatusInterface|null|object
     */
    public function getDefaultStatus()
    {
        return $this->getRepository()->findOneBy(['name' => $this->defaultStatusName]);
    }
}
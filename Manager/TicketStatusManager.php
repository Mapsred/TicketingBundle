<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

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
    public function getDefaultStatus(): TicketStatusInterface
    {
        if (null === $status = $this->getRepository()->findOneBy(['name' => $this->getDefaultStatusName()])) {
            throw new InvalidArgumentException(sprintf(
                    "No %s found with the name %s. please check the ticketing.default_status_name parameter.",
                    $this->getClass(),
                    $this->getDefaultStatusName())
            );
        }

        return $status;
    }

    /**
     * @return string
     */
    public function getDefaultStatusName(): string
    {
        return $this->defaultStatusName;
    }
}
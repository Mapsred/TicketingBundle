<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class TicketStatusManager extends AbstractManager
{
    /** @var array $ticketStatus */
    private $ticketStatus;

    /**
     * TicketStatusManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param array $ticketStatus
     */
    public function __construct(EntityManagerInterface $manager, string $class, array $ticketStatus)
    {
        parent::__construct($manager, $class);
        $this->ticketStatus = $ticketStatus;
    }

    /**
     * @return TicketStatusInterface|null|object
     */
    public function getOpenStatus(): TicketStatusInterface
    {
        return $this->getStatus('open');
    }

    /**
     * @return mixed|null|object
     */
    public function getClosedStatus()
    {
        return $this->getStatus('closed');
    }

    /**
     * @return mixed|null|object
     */
    public function getPendingStatus()
    {
        return $this->getStatus('pending');
    }

    /**
     * @param $type
     * @return mixed|null|object
     */
    public function getStatus($type)
    {
        $status = $this->ticketStatus[$type];
        if (null === $status = $this->getRepository()->findOneBy(['name' => $status])) {
            throw new InvalidArgumentException(sprintf(
                    "No %s found with the name %s. please check the ticketing.ticket_status.%s parameter.",
                    $this->getClass(),
                    $status,
                    $type)
            );
        }

        return $status;
    }

}
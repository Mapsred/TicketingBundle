<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Entity\Ticket;
use Maps_red\TicketingBundle\Entity\TicketStatus;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TicketManager extends AbstractManager
{
    /** @var string $defaultStatusName */
    private $defaultStatusName;

    /** @var bool $enableHistory */
    private $enableHistory;

    /**
     * @var TicketStatusManager
     */
    private $ticketStatusManager;

    /**
     * TicketManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param string $defaultStatusName
     * @param bool $enableHistory
     * @param TicketStatusManager $ticketStatusManager
     */
    public function __construct(EntityManagerInterface $manager, string $class, string $defaultStatusName, bool $enableHistory, TicketStatusManager $ticketStatusManager)
    {
        $this->defaultStatusName = $defaultStatusName;
        $this->enableHistory = $enableHistory;
        parent::__construct($manager, $class);
        $this->ticketStatusManager = $ticketStatusManager;
    }

    /**
     * @param UserInterface $user
     * @param Ticket $ticket
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTicket(UserInterface $user, Ticket $ticket){
        $status = $this->ticketStatusManager->getRepository()->findOneBy(['name' => $this->defaultStatusName]);
        /** @var TicketStatus $status */
        $ticket
            ->setStatus($status)
            ->setPublicAt(new \DateTime())
            ->setPublic(0)
            ->setAuthor($user);
        $this->persistAndFlush($ticket);
    }
}
<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TicketManager extends AbstractManager
{
    /** @var bool $enableHistory */
    private $enableHistory;

    /** @var bool $enableTicketRestriction */
    private $enableTicketRestriction;

    /** @var TicketStatusManager $ticketStatusManager */
    private $ticketStatusManager;

    /**
     * TicketManager constructor.
     * @param EntityManagerInterface $manager
     * @param string $class
     * @param bool $enableHistory
     * @param bool $enableTicketRestriction
     * @param TicketStatusManager $ticketStatusManager
     */
    public function __construct(EntityManagerInterface $manager, string $class, bool $enableHistory, bool $enableTicketRestriction,
                                TicketStatusManager $ticketStatusManager)
    {
        parent::__construct($manager, $class);
        $this->enableHistory = $enableHistory;
        $this->enableTicketRestriction = $enableTicketRestriction;
        $this->ticketStatusManager = $ticketStatusManager;
    }

    /**
     * @param UserInterface $user
     * @param TicketInterface $ticket
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTicket(UserInterface $user, TicketInterface $ticket)
    {
        $status = $this->ticketStatusManager->getDefaultStatus();
        $ticket->setStatus($status)->setAuthor($user);

        if ($this->enableTicketRestriction) {
            $ticket->setPublicAt(new \DateTime())->setPublic(true);
        }

        $this->persistAndFlush($ticket);
    }
}
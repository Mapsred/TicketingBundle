<?php

namespace Maps_red\TicketingBundle\Event;

use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Symfony\Component\EventDispatcher\Event;

class TicketStatusHistoryEvent extends Event
{
    const NAME = 'ticketing.status_history_event';

    /** @var TicketStatusInterface $ticketStatus */
    private $ticketStatus;

    /** @var TicketInterface $ticket */
    private $ticket;

    public function __construct(TicketStatusInterface $ticketStatus, TicketInterface $ticket)
    {
        $this->ticket = $ticket;
        $this->ticketStatus = $ticketStatus;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }

    public function getTicketStatus(): TicketStatusInterface
    {
        return $this->ticketStatus;
    }
}

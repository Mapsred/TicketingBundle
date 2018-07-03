<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 01/06/2018
 * Time: 21:26
 */

namespace Maps_red\TicketingBundle\Event;

use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\EventDispatcher\Event;

class TicketUnseenEvent extends Event
{
    const NAME = 'ticketing.unseen';

    protected $ticket;

    public function __construct(TicketInterface $ticket)
    {
        $this->ticket = $ticket;
    }

    public function getTicket()
    {
        return $this->ticket;
    }
}
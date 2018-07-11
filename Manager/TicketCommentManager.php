<?php

namespace Maps_red\TicketingBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Repository\TicketCommentRepository;

/**
 * @method TicketCommentRepository getRepository
 */
class TicketCommentManager extends AbstractManager
{
    /**
     * @param TicketInterface $ticket
     * @return ArrayCollection
     */
    public function getTicketComments(TicketInterface $ticket)
    {
        return new ArrayCollection($this->getRepository()->getTicketComments($ticket));
    }
}

<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketInterface;

class TicketCommentRepository extends ServiceEntityRepository
{
    /**
     * @param TicketInterface $ticket
     * @return array
     */
    public function getTicketComments(TicketInterface $ticket)
    {
        return $this->findBy(['ticket' => $ticket]);
    }
}

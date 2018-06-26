<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketInterface;

class TicketCommentRepository extends ServiceEntityRepository
{
    /**
     * @param TicketInterface $ticket
     * @return TicketInterface[]
     */
    public function findLastTwoByTicket(TicketInterface $ticket)
    {
        return $this->createQueryBuilder('q')
            ->where("q.ticket = :ticket")
            ->orderBy("q.id", "DESC")
            ->setMaxResults(2)
            ->setParameters(["ticket" => $ticket])
            ->getQuery()
            ->getResult();
    }

}
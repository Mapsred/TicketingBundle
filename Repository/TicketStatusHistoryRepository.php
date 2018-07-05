<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketInterface;

class TicketStatusHistoryRepository extends ServiceEntityRepository
{
    public function getTicketStatusHistory(TicketInterface $ticket)
    {
        return $this->findBy(['ticket' => $ticket]);
    }
}
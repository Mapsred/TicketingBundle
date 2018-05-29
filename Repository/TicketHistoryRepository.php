<?php

namespace Maps_red\TicketingBundle\Repository;

use Maps_red\TicketingBundle\Entity\TicketHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketHistory[]    findAll()
 * @method TicketHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketHistory::class);
    }
}

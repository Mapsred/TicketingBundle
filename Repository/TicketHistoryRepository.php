<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketHistoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketHistoryInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketHistoryInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketHistoryInterface[]    findAll()
 * @method TicketHistoryInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketHistoryInterface::class);
    }
}

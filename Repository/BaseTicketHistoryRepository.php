<?php

namespace Maps_red\Ticketing\Repository;

use Maps_red\Ticketing\Entity\BaseTicketHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BaseTicketHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseTicketHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseTicketHistory[]    findAll()
 * @method BaseTicketHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseTicketHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BaseTicketHistory::class);
    }
}

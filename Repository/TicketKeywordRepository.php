<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketKeywordInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketKeywordInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketKeywordInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketKeywordInterface[]    findAll()
 * @method TicketKeywordInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketKeywordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketKeywordInterface::class);
    }
}

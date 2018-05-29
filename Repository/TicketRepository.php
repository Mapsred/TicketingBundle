<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketInterface[]    findAll()
 * @method TicketInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketInterface::class);
    }
}


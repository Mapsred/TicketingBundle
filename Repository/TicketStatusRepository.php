<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketStatusInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketStatusInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketStatusInterface[]    findAll()
 * @method TicketStatusInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketStatusInterface::class);
    }

}

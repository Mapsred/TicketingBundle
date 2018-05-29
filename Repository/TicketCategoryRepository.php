<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketCategoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketCategoryInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketCategoryInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketCategoryInterface[]    findAll()
 * @method TicketCategoryInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketCategoryInterface::class);
    }
}

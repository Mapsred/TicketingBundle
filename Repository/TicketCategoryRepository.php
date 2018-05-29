<?php

namespace Maps_red\TicketingBundle\Repository;

use Maps_red\TicketingBundle\Entity\TicketCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketCategory[]    findAll()
 * @method TicketCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketCategory::class);
    }
}

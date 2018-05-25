<?php

namespace Maps_red\TicketingBundle\Repository;

use Maps_red\TicketingBundle\Entity\BaseTicketCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BaseTicketCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseTicketCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseTicketCategory[]    findAll()
 * @method BaseTicketCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseTicketCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BaseTicketCategory::class);
    }
}

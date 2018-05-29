<?php

namespace Maps_red\TicketingBundle\Repository;

use Maps_red\TicketingBundle\Entity\TicketKeyword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketKeyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketKeyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketKeyword[]    findAll()
 * @method TicketKeyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketKeywordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketKeyword::class);
    }
}

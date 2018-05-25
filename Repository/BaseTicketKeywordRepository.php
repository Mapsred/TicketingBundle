<?php

namespace Maps_red\TicketingBundle\Repository;

use Maps_red\TicketingBundle\Entity\BaseTicketKeyword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BaseTicketKeyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseTicketKeyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseTicketKeyword[]    findAll()
 * @method BaseTicketKeyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseTicketKeywordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BaseTicketKeyword::class);
    }
}

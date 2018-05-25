<?php

namespace Maps_red\Ticketing\Repository;

use Maps_red\Ticketing\Entity\BaseTicketStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BaseTicketStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseTicketStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseTicketStatus[]    findAll()
 * @method BaseTicketStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseTicketStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BaseTicketStatus::class);
    }

}

<?php

namespace Maps_red\Ticketing\Repository;

use Maps_red\Ticketing\Entity\BaseTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BaseTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseTicket[]    findAll()
 * @method BaseTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseTicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BaseTicket::class);
    }
}


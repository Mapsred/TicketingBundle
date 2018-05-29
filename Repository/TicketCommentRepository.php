<?php

namespace Maps_red\TicketingBundle\Repository;

use Maps_red\TicketingBundle\Entity\TicketComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketComment[]    findAll()
 * @method TicketComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketComment::class);
    }
}


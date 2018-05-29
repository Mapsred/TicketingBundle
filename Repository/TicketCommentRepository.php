<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Maps_red\TicketingBundle\Model\TicketCommentInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketCommentInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketCommentInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketCommentInterface[]    findAll()
 * @method TicketCommentInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketCommentInterface::class);
    }
}


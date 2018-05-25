<?php

namespace Maps_red\TicketingBundle\Repository;

use Maps_red\TicketingBundle\Entity\BaseTicketComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BaseTicketComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseTicketComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseTicketComment[]    findAll()
 * @method BaseTicketComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseTicketCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BaseTicketComment::class);
    }
}


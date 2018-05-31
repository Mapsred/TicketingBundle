<?php

use Doctrine\ORM\EntityManagerInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;

class TicketManager extends AbstractManager
{
    public function __construct(EntityManagerInterface $manager, string $defaultStatusName)
    {
        parent::__construct($manager, TicketInterface ::class);
    }
}
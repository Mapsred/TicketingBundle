<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 04/07/2018
 * Time: 13:32
 */

namespace Maps_red\TicketingBundle\Model;


use Symfony\Component\Security\Core\User\UserInterface;

interface TicketStatusHistoryInterface
{
    public function getId() : ?int;

    public function getAuthor(): ?UserInterface;

    public function setAuthor(?UserInterface $author): TicketStatusHistoryInterface;

    public function getTicket(): ?TicketInterface;

    public function setTicket(?TicketInterface $ticket):? TicketStatusHistoryInterface;

    public function getStatus(): ?TicketStatusInterface;

    public function setStatus(?TicketStatusInterface $status):? TicketStatusHistoryInterface;
}
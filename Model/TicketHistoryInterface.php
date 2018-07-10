<?php

namespace Maps_red\TicketingBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface TicketHistoryInterface
{
    public function getId() : ?int;

    public function getStatus(): ?int;

    public function setStatus(int $status): TicketHistoryInterface;

    public function getAuthor(): ?UserInterface;

    public function setAuthor(?UserInterface $author): TicketHistoryInterface;

    public function getTicket(): ?TicketInterface;

    public function setTicket(TicketInterface $ticket): TicketHistoryInterface;
}
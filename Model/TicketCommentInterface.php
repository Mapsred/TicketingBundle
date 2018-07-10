<?php

namespace Maps_red\TicketingBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface TicketCommentInterface
{
    public function getId() : ?int;

    public function getText(): ?string;

    public function setText(?string $text): TicketCommentInterface;

    public function getAuthor(): ?UserInterface;

    public function setAuthor(?UserInterface $author): TicketCommentInterface;

    public function getTicket(): ?TicketInterface;

    public function setTicket($ticket):? TicketCommentInterface;
}
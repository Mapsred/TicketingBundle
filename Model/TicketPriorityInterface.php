<?php

namespace Maps_red\TicketingBundle\Model;

interface TicketPriorityInterface
{
    public function getId() : ?int;

    public function getName() : ?string;

    public function setName(string $name): TicketPriorityInterface;

    public function getValue(): ?string;

    public function setValue(string $value): TicketPriorityInterface;
}
<?php

namespace Maps_red\TicketingBundle\Model;

interface TicketCategoryInterface
{
    public function getId() : ?int;

    public function getName() : ?string;

    public function setName(string $name): TicketCategoryInterface;

    public function getValue(): ?string;

    public function setValue(string $value): TicketCategoryInterface;

    public function getPosition() : ?int;

    public function setPosition(int $position): TicketCategoryInterface;

    public function getRole() : ?string;

    public function setRole(string $role): TicketCategoryInterface;
}

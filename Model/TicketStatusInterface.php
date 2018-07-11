<?php

namespace Maps_red\TicketingBundle\Model;

interface TicketStatusInterface
{
    public function getName(): ?string;

    public function setName(string $name): TicketStatusInterface;

    public function getValue(): ?string;

    public function setValue(string $value): TicketStatusInterface;

    public function getStyle(): ?string;

    public function setStyle(?string $style): TicketStatusInterface;

    public function getId() : ?int;
}

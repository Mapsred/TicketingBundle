<?php
/**
 * Created by PhpStorm.
 * User: fma
 * Date: 25/05/18
 * Time: 17:41
 */

namespace Maps_red\TicketingBundle\Model;


interface TicketPriorityInterface
{
    public function getId() : ?int;

    public function getName() : ?string;

    public function setName(string $name): TicketPriorityInterface;

    public function getValue(): ?string;

    public function setValue(string $value): TicketPriorityInterface;
}
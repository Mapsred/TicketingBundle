<?php
namespace Maps_red\TicketingBundle\Model;


interface TicketKeywordInterface
{

    public function getId() : ?int;

    public function getName() : ?string;

    public function setName(string $name): TicketKeywordInterface;

}
<?php
/**
 * Created by PhpStorm.
 * User: fma
 * Date: 25/05/18
 * Time: 17:41
 */

namespace Maps_red\TicketingBundle\Model;


interface TicketCategoryInterface
{

    public function getId() : ?int;

    public function getName() : ?string;

    public function setName(string $name): TicketCategoryInterface;

    public function getPosition() : ?int;

    public function setPosition(int $position): TicketCategoryInterface;

    public function getRole() : ?string;

    public function setRole(string $role): TicketCategoryInterface;

}
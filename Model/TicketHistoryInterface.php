<?php
/**
 * Created by PhpStorm.
 * User: fma
 * Date: 25/05/18
 * Time: 17:42
 */

namespace Maps_red\TicketingBundle\Model;


interface TicketHistoryInterface
{

    public function getId() : ?int;

    public function getStatus(): ?int;

    public function setStatus(int $status): TicketHistoryInterface;

    public function getAuthor(): ?UserInterface;

    public function setAuthor(?UserInterface $author): TicketHistoryInterface;

}
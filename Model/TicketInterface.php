<?php
/**
 * Created by PhpStorm.
 * User: fma
 * Date: 25/05/18
 * Time: 17:41
 */

namespace Maps_red\TicketingBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface TicketInterface
{
    public function getStatus(): ?TicketStatusInterface;

    public function setStatus(?TicketStatusInterface $status): self;

    public function getPublicAt(): ?\DateTimeInterface;

    public function setPublicAt(\DateTimeInterface $public_at): self;

    public function getPublic(): ?bool;

    public function setPublic(bool $public): self;

    public function getAuthor(): ?UserInterface;

    public function setAuthor(?UserInterface $author): self;

}
<?php

namespace Maps_red\TicketingBundle\Model;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

interface TicketInterface
{
    public function getId() : ?int;

    public function getDescription() : ?string;

    public function setDescription(string $description): TicketInterface;

    public function getStatus(): ?TicketStatusInterface;

    public function setStatus(?TicketStatusInterface $status): TicketInterface;

    public function getCategory(): ?TicketCategoryInterface;

    public function setCategory(?TicketCategoryInterface $category): TicketInterface;

    public function getPublic(): ?bool;

    public function setPublic(bool $public): TicketInterface;

    public function getPublicBy(): ?UserInterface;

    public function setPublicBy(?UserInterface $publicBy): TicketInterface;

    public function getAuthor(): ?UserInterface;

    public function setAuthor(?UserInterface $author): TicketInterface;

    public function getAssignated(): ?UserInterface;

    public function setAssignated(?UserInterface $assignated = null): TicketInterface;

    public function getRating(): ?int;

    public function setRating(?int $rating): TicketInterface;

    public function getClosureResponse(): ?string;

    public function setClosureResponse(?string $closure_response): TicketInterface;

    public function getClosedAt(): ?\DateTimeInterface;

    public function setClosedAt(?\DateTimeInterface $closed_at): TicketInterface;

    public function getClosedBy(): ?UserInterface;

    public function setClosedBy(?UserInterface $closed_by): TicketInterface;

    public function getPublicAt(): ?\DateTimeInterface;

    public function setPublicAt(?\DateTimeInterface $public_at): TicketInterface;

    public function getPriority(): ?TicketPriorityInterface;

    public function setPriority(?TicketPriorityInterface $priority): TicketInterface;

    public function addReference(TicketInterface $ticket): TicketInterface;

    public function removeReference(TicketInterface $ticket): TicketInterface;

    public function setReferences($references): TicketInterface;

    public function getReferences(): ?Collection;

    public function getCreatedAt(): ?\DateTime;

    public function isClosed(): bool;

    public function isOpen(): bool;

    public function isPending(): bool;

    public function isWaiting(): bool;

}
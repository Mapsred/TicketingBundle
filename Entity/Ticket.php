<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketCategoryInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\MappedSuperclass()
 */
class Ticket implements TicketInterface
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketStatusInterface")
     * @ORM\JoinColumn(name="status", referencedColumnName="id", nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketCategoryInterface")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(name="author", referencedColumnName="id", nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $closed_at;

    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(name="closed_by", referencedColumnName="id", nullable=true)
     */
    private $closed_by;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $public_at;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?TicketStatusInterface
    {
        return $this->status;
    }

    public function setStatus(?TicketStatusInterface $status): TicketInterface
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?TicketCategoryInterface
    {
        return $this->category;
    }

    public function setCategory(?TicketCategoryInterface $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): TicketInterface
    {
        $this->public = $public;

        return $this;
    }

    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    public function setAuthor(?UserInterface $author): TicketInterface
    {
        $this->author = $author;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getClosedAt(): ?\DateTimeInterface
    {
        return $this->closed_at;
    }

    public function setClosedAt(\DateTimeInterface $closed_at): self
    {
        $this->closed_at = $closed_at;

        return $this;
    }

    public function getClosedBy(): ?UserInterface
    {
        return $this->closed_by;
    }

    public function setClosedBy(?UserInterface $closed_by): self
    {
        $this->closed_by = $closed_by;

        return $this;
    }

    public function getPublicAt(): ?\DateTimeInterface
    {
        return $this->public_at;
    }

    public function setPublicAt(\DateTimeInterface $public_at): TicketInterface
    {
        $this->public_at = $public_at;

        return $this;
    }
}

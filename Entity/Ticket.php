<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketCategoryInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Maps_red\TicketingBundle\Model\UserInterface;

/**
 * @ORM\MappedSuperclass()
 */
class Ticket implements TicketInterface
{
    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketStatusInterface")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketCategoryInterface")
     */
    private $category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\UserInterface", inversedBy="tickets")
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     */
    private $closed_at;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\UserInterface")
     */
    private $closed_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $public_at;

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

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

    public function setStatus(?TicketStatusInterface $status): self
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

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    public function setAuthor(?UserInterface $author): self
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

    public function setPublicAt(\DateTimeInterface $public_at): self
    {
        $this->public_at = $public_at;

        return $this;
    }
}

<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketCategoryInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Maps_red\TicketingBundle\Model\TicketPriorityInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Maps_red\TicketingBundle\Model\Traits\Timestampable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\MappedSuperclass()
 */
class Ticket implements TicketInterface
{
    use Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @ORM\JoinColumn(name="public_by", referencedColumnName="id", nullable=true)
     */
    private $public_by;

    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(name="author", referencedColumnName="id", nullable=true)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(name="assignated", referencedColumnName="id", nullable=true)
     */
    private $assignated;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="text", length=65535, nullable=true)
     */
    private $closure_response;

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

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketPriorityInterface")
     * @ORM\JoinColumn(name="priority", referencedColumnName="id", nullable=true)
     */
    private $priority;

    /**
     * @ORM\ManyToMany(targetEntity="Maps_red\TicketingBundle\Model\TicketInterface", cascade={"persist"})
     * @ORM\JoinTable(name="ticket_join_reference",
     *      joinColumns={@ORM\JoinColumn(name="ticket_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="reference_id", referencedColumnName="id")}
     * )
     */
    private $references;

    /**
     * Ticket constructor.
     */
    public function __construct()
    {
        $this->references = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): TicketInterface
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

    public function setCategory(?TicketCategoryInterface $category): TicketInterface
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

    public function getPublicBy(): ?UserInterface
    {
        return $this->public_by;
    }

    public function setPublicBy(?UserInterface $publicBy): TicketInterface
    {
        $this->public_by = $publicBy;

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

    public function getAssignated(): ?UserInterface
    {
        return $this->assignated;
    }

    public function setAssignated(?UserInterface $assignated = null): TicketInterface
    {
        $this->assignated = $assignated;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): TicketInterface
    {
        $this->rating = $rating;

        return $this;
    }

    public function getClosureResponse(): ?string
    {
        return $this->closure_response;
    }

    public function setClosureResponse(?string $closure_response): TicketInterface
    {
        $this->closure_response = $closure_response;

        return $this;
    }

    public function getClosedAt(): ?\DateTimeInterface
    {
        return $this->closed_at;
    }

    public function setClosedAt(?\DateTimeInterface $closed_at): TicketInterface
    {
        $this->closed_at = $closed_at;

        return $this;
    }

    public function getClosedBy(): ?UserInterface
    {
        return $this->closed_by;
    }

    public function setClosedBy(?UserInterface $closed_by): TicketInterface
    {
        $this->closed_by = $closed_by;

        return $this;
    }

    public function getPublicAt(): ?\DateTimeInterface
    {
        return $this->public_at;
    }

    public function setPublicAt(?\DateTimeInterface $public_at): TicketInterface
    {
        $this->public_at = $public_at;

        return $this;
    }

    public function getPriority(): ?TicketPriorityInterface
    {
        return $this->priority;
    }

    public function setPriority(?TicketPriorityInterface $priority): TicketInterface
    {
        $this->priority = $priority;

        return $this;
    }

    public function addReference(TicketInterface $ticket): TicketInterface
    {
        if (!$this->references->contains($ticket)) {
            $this->references->add($ticket);
        }

        return $this;
    }

    public function removeReference(TicketInterface $ticket): TicketInterface
    {
        if ($this->references->contains($ticket)) {
            $this->references->removeElement($ticket);
        }

        return $this;
    }

    public function setReferences($references): TicketInterface
    {
        $this->references = $references;

        return $this;
    }

    public function getReferences(): ?Collection
    {
        return $this->references;
    }

    public function isClosed(): bool
    {
        return $this->getStatus()->getName() == "closed";
    }

    public function isOpen(): bool
    {
        return $this->getStatus()->getName() == "open";
    }

    public function isPending(): bool
    {
        return $this->getStatus()->getName() == "pending";
    }

    public function isWaiting(): bool
    {
        return $this->getStatus()->getName() == "waiting";
    }
}

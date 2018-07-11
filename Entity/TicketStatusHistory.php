<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketStatusHistoryInterface;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;
use Maps_red\TicketingBundle\Model\Traits\Timestampable;
use Symfony\Component\Security\Core\User\UserInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;

/**
 * @ORM\MappedSuperclass()
 */
class TicketStatusHistory implements TicketStatusHistoryInterface
{
    use Timestampable;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(name="author", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketInterface")
     * @ORM\JoinColumn(name="ticket", referencedColumnName="id", nullable=false)
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketStatusInterface")
     * @ORM\JoinColumn(name="status", referencedColumnName="id", nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    public function setAuthor(?UserInterface $author): TicketStatusHistoryInterface
    {
        $this->author = $author;

        return $this;
    }

    public function getTicket(): ?TicketInterface
    {
        return $this->ticket;
    }

    public function setTicket(?TicketInterface $ticket):? TicketStatusHistoryInterface
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getStatus(): ?TicketStatusInterface
    {
        return $this->status;
    }

    public function setStatus(?TicketStatusInterface $status): TicketStatusHistoryInterface
    {
        $this->status = $status;

        return $this;
    }
}

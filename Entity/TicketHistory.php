<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketHistoryInterface;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\MappedSuperclass()
 */
class TicketHistory implements TicketHistoryInterface
{
    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     */
    private $author;

    /**
     * @var TicketInterface $ticket
     * @ORM\ManyToOne(targetEntity="Maps_red\TicketingBundle\Model\TicketInterface")
     */
    private $ticket;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): TicketHistoryInterface
    {
        $this->status = $status;

        return $this;
    }

    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    public function setAuthor(?UserInterface $author): TicketHistoryInterface
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return TicketInterface
     */
    public function getTicket(): ?TicketInterface
    {
        return $this->ticket;
    }

    /**
     * @param TicketInterface $ticket
     * @return TicketHistory
     */
    public function setTicket(TicketInterface $ticket): TicketHistoryInterface
    {
        $this->ticket = $ticket;

        return $this;
    }

}

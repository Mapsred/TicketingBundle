<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketCategoryInterface;

/**
 * @ORM\MappedSuperclass()
 */
class TicketCategory implements TicketCategoryInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $position = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role = 'ROLE_USER';

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): TicketCategoryInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): TicketCategoryInterface
    {
        $this->position = $position;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): TicketCategoryInterface
    {
        $this->role = $role;

        return $this;
    }
}

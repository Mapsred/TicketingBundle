<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketStatusInterface;

/**
 * @ORM\MappedSuperclass()
 */
class TicketStatus implements TicketStatusInterface
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $style;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): TicketStatusInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): TicketStatusInterface
    {
        $this->value = $value;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): TicketStatusInterface
    {
        $this->style = $style;

        return $this;
    }
}

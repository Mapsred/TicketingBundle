<?php

namespace Maps_red\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\Traits\Timestampable;
use Maps_red\TicketingBundle\Model\TicketKeywordInterface;

/**
 * @ORM\MappedSuperclass()
 */
class TicketKeyword implements TicketKeywordInterface
{
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): TicketKeywordInterface
    {
        $this->name = $name;

        return $this;
    }
}

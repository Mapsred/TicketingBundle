<?php
/**
 * Created by PhpStorm.
 * User: fma
 * Date: 22/06/18
 * Time: 16:02
 */

namespace Maps_red\TicketingBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Maps_red\TicketingBundle\Model\TicketPriorityInterface;

/**
 * @ORM\MappedSuperclass()
 */

class TicketPriority implements TicketPriorityInterface
{
    /**
     * @var integer
     *
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
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): TicketPriorityInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): TicketPriorityInterface
    {
        $this->value = $value;

        return $this;
    }
}
<?php

namespace Maps_red\TicketingBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Updates createdAt and updatedAt timestamps.
     */
    public function updateTimestamps()
    {
        // Create a datetime with microseconds
        $dateTime = \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)));
        $dateTime->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        if (null === $this->createdAt) {
            $this->createdAt = $dateTime;
        }

        $this->updatedAt = $dateTime;
    }

}
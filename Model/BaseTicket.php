<?php
/**
 * Created by PhpStorm.
 * User: fma
 * Date: 25/05/18
 * Time: 17:42
 */

namespace Maps_red\TicketingBundle\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

class BaseTicket
{
    use ORMBehaviors\Timestampable\Timestampable;

    /** @var string $title */
    private $title;
    /** @var string $description */
    private $description;

    /** @var TicketStatusInterface $status */
    private $status;
    /** @var TicketCategoryInterface $category */
    private $category;
    /** @var boolean $public */
    private $public;
    /** @var UserInterface $author */
    private $author;
    /** @var integer $rating */
    private $rating;

    /** @var ArrayCollection $comments */
    private $comments;
    /** @var ArrayCollection $references */
    private $references;

    /** @var \DateTime $closed_at */
    private $closed_at;
    /** @var UserInterface $closed_by */
    private $closed_by;

    /** @var \DateTime $public_at */
    private $public_at;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return BaseTicket
     */
    public function setTitle(string $title): BaseTicket
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return BaseTicket
     */
    public function setDescription(string $description): BaseTicket
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return TicketStatusInterface
     */
    public function getStatus(): TicketStatusInterface
    {
        return $this->status;
    }

    /**
     * @param TicketStatusInterface $status
     * @return BaseTicket
     */
    public function setStatus(TicketStatusInterface $status): BaseTicket
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return TicketCategoryInterface
     */
    public function getCategory(): TicketCategoryInterface
    {
        return $this->category;
    }

    /**
     * @param TicketCategoryInterface $category
     * @return BaseTicket
     */
    public function setCategory(TicketCategoryInterface $category): BaseTicket
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @param bool $public
     * @return BaseTicket
     */
    public function setPublic(bool $public): BaseTicket
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getAuthor(): UserInterface
    {
        return $this->author;
    }

    /**
     * @param UserInterface $author
     * @return BaseTicket
     */
    public function setAuthor(UserInterface $author): BaseTicket
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     * @return BaseTicket
     */
    public function setRating(int $rating): BaseTicket
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments(): ArrayCollection
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     * @return BaseTicket
     */
    public function setComments(ArrayCollection $comments): BaseTicket
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getReferences(): ArrayCollection
    {
        return $this->references;
    }

    /**
     * @param ArrayCollection $references
     * @return BaseTicket
     */
    public function setReferences(ArrayCollection $references): BaseTicket
    {
        $this->references = $references;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getClosedAt(): \DateTime
    {
        return $this->closed_at;
    }

    /**
     * @param \DateTime $closed_at
     * @return BaseTicket
     */
    public function setClosedAt(\DateTime $closed_at): BaseTicket
    {
        $this->closed_at = $closed_at;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getClosedBy(): UserInterface
    {
        return $this->closed_by;
    }

    /**
     * @param UserInterface $closed_by
     * @return BaseTicket
     */
    public function setClosedBy(UserInterface $closed_by): BaseTicket
    {
        $this->closed_by = $closed_by;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getPublicAt(): \DateTime
    {
        return $this->public_at;
    }

    /**
     * @param \DateTime $public_at
     * @return BaseTicket
     */
    public function setPublicAt(\DateTime $public_at): BaseTicket
    {
        $this->public_at = $public_at;

        return $this;
    }

}
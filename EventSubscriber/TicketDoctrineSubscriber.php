<?php

namespace Maps_red\TicketingBundle\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Maps_red\TicketingBundle\Entity\Ticket;
use Maps_red\TicketingBundle\Event\TicketUnseenEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TicketDoctrineSubscriber implements EventSubscriber
{
    /** @var EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;

    /**
     * TicketDoctrineSubscriber constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [Events::postPersist, Events::postUpdate];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->handle($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->handle($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function handle(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Ticket) {
            $event = new TicketUnseenEvent($entity);
            $this->eventDispatcher->dispatch(TicketUnseenEvent::NAME, $event);
        }
    }
}
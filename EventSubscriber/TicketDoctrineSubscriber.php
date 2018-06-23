<?php

namespace Maps_red\TicketingBundle\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Maps_red\TicketingBundle\Event\TicketUnseenEvent;
use Maps_red\TicketingBundle\Model\TicketInterface;
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
        return [Events::prePersist, Events::preUpdate, Events::postPersist, Events::postUpdate];
    }


    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->preHandle($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->preHandle($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->postHandle($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->postHandle($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preHandle(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (method_exists($entity, 'updateTimestamps')) {
            call_user_func([$entity, 'updateTimestamps']);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postHandle(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TicketInterface) {
            $event = new TicketUnseenEvent($entity);
            $this->eventDispatcher->dispatch(TicketUnseenEvent::NAME, $event);
        }
    }
}
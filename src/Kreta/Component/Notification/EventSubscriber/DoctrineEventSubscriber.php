<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kreta\Component\Notification\EventSubscriber\Abstracts\AbstractEventSubscriber;

/**
 * Class DoctrineEventListener.
 *
 * @package Kreta\Component\Notification\EventListener
 */
class DoctrineEventSubscriber extends AbstractEventSubscriber implements EventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preRemove,
            Events::postRemove,
            Events::prePersist,
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate
        ];
    }

    /**
     * Handles preRemove event triggered by doctrine.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The lifecycle event arguments
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->handleEvent('preRemove', $args->getObject(), $args->getObjectManager());
    }

    /**
     * Handles preRemove event triggered by doctrine.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The lifecycle event arguments
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->handleEvent('postRemove', $args->getObject(), $args->getObjectManager());
    }

    /**
     * Handles prePersist event triggered by doctrine.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The lifecycle event arguments
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->handleEvent('prePersist', $args->getObject(), $args->getObjectManager());
    }

    /**
     * Handles postPersist event triggered by doctrine.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The lifecycle event arguments
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->handleEvent('postPersist', $args->getObject(), $args->getObjectManager());
    }

    /**
     * Handles preUpdate event triggered by doctrine.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The lifecycle event arguments
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->handleEvent('preUpdate', $args->getObject(), $args->getObjectManager());
    }

    /**
     * Handles postUpdate event triggered by doctrine.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args The lifecycle event arguments
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->handleEvent('postUpdate', $args->getObject(), $args->getObjectManager());
    }
}

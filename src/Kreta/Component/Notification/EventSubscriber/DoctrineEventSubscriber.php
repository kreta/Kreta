<?php

/**
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

/**
 * Class DoctrineEventListener
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
        return array(
            Events::preRemove,
            Events::postRemove,
            Events::prePersist,
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate
        );
    }

    /**
     * Handles preRemove event triggered by doctrine
     *
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->handleEvent('preRemove', $args->getObject());
    }

    /**
     * Handles preRemove event triggered by doctrine
     *
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->handleEvent('postRemove', $args->getObject());
    }

    /**
     * Handles prePersist event triggered by doctrine
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->handleEvent('prePersist', $args->getObject());
    }

    /**
     * Handles postPersist event triggered by doctrine
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->handleEvent('postPersist', $args->getObject());
    }

    /**
     * Handles preUpdate event triggered by doctrine
     *
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->handleEvent('preUpdate', $args->getObject());
    }

    /**
     * Handles postUpdate event triggered by doctrine
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->handleEvent('postUpdate', $args->getObject());
    }
}

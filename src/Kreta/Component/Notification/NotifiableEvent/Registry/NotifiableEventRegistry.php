<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\NotifiableEvent\Registry;

use Kreta\Component\Notification\NotifiableEvent\NotifiableEventInterface;

/**
 * Class NotifiableEventRegistry
 *
 * @package Kreta\Component\Notification\NotifiableEvent\Registry
 */
class NotifiableEventRegistry implements NotifiableEventRegistryInterface
{
    protected $notifiableEvents = [];

    /**
     * @{@inheritdoc}
     */
    public function getNotifiableEvents()
    {
        return $this->notifiableEvents;
    }

    /**
     * @{@inheritdoc}
     */
    public function registerNotifiableEvent($name, NotifiableEventInterface $NotifiableEvent)
    {
        if ($this->hasNotifiableEvent($name)) {
            throw new ExistingNotifiableEventException($name);
        }
        $this->notifiableEvents[$name] = $NotifiableEvent;
    }

    /**
     * @{@inheritdoc}
     */
    public function unregisterNotifiableEvent($name)
    {
        if (!$this->hasNotifiableEvent($name)) {
            throw new NonExistingNotifiableEventException($name);
        }
        unset($this->notifiableEvents[$name]);
    }

    /**
     * @{@inheritdoc}
     */
    public function hasNotifiableEvent($name)
    {
        return isset($this->notifiableEvents[$name]);
    }

    /**
     * @{@inheritdoc}
     */
    public function getNotifiableEvent($name)
    {
        if (!$this->hasNotifiableEvent($name)) {
            throw new NonExistingNotifiableEventException($name);
        }
        return $this->notifiableEvents[$name];
    }

}

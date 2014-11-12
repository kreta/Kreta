<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Notifier\Registry;

use Kreta\Component\Notification\Notifier\NotifierInterface;

/**
 * Class NotifierRegistry
 *
 * @package Kreta\Component\Notification\Notifier\Registry
 */
class NotifierRegistry implements NotifierRegistryInterface
{
    protected $notifiers = array();

    /**
     * @{@inheritdoc}
     */
    public function getNotifiers()
    {
        return $this->notifiers;
    }

    /**
     * @{@inheritdoc}
     */
    public function registerNotifier($name, NotifierInterface $notifier)
    {
        if ($this->hasNotifier($name)) {
            throw new ExistingNotifierException($name);
        }
        $this->notifiers[$name] = $notifier;
    }

    /**
     * @{@inheritdoc}
     */
    public function unregisterNotifier($name)
    {
        if (!$this->hasNotifier($name)) {
            throw new NonExistingNotifierException($name);
        }
        unset($this->notifiers[$name]);
    }

    /**
     * @{@inheritdoc}
     */
    public function hasNotifier($name)
    {
        return isset($this->notifiers[$name]);
    }

    /**
     * @{@inheritdoc}
     */
    public function getNotifier($name)
    {
        if (!$this->hasNotifier($name)) {
            throw new NonExistingNotifierException($name);
        }
        return $this->notifiers[$name];
    }

}

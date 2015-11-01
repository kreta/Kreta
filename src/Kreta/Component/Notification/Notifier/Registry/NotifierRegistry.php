<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Component\Notification\Notifier\Registry;

use Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface;
use Kreta\Component\Notification\Notifier\Registry\Interfaces\NotifierRegistryInterface;

/**
 * Class NotifierRegistry.
 *
 * @package Kreta\Component\Notification\Notifier\Registry
 */
class NotifierRegistry implements NotifierRegistryInterface
{
    /**
     * Array which contains notifiers.
     *
     * @var \Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface[]
     */
    protected $notifiers = [];

    /**
     * {@inheritdoc}
     */
    public function getNotifiers()
    {
        return $this->notifiers;
    }

    /**
     * {@inheritdoc}
     */
    public function registerNotifier($name, NotifierInterface $notifier)
    {
        if ($this->hasNotifier($name)) {
            throw new ExistingNotifierException($name);
        }
        $this->notifiers[$name] = $notifier;
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterNotifier($name)
    {
        if (!$this->hasNotifier($name)) {
            throw new NonExistingNotifierException($name);
        }
        unset($this->notifiers[$name]);
    }

    /**
     * {@inheritdoc}
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

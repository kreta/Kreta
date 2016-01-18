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

namespace Kreta\Component\Notification\Notifier\Registry\Interfaces;

use Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface;

/**
 * Interface NotifierRegistryInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface NotifierRegistryInterface
{
    /**
     * Returns registered notifiers.
     *
     * @return \Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface[] All registered notifiers
     */
    public function getNotifiers();

    /**
     * Register notifier.
     *
     * @param string                                                              $name     The name for the notifier
     * @param \Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface $notifier The notifier
     */
    public function registerNotifier($name, NotifierInterface $notifier);

    /**
     * Unregister notifier.
     *
     * @param string $name The name of the notifier to be unregistered. Must exist in the registry
     *
     * @return void
     */
    public function unregisterNotifier($name);

    /**
     * Check if the notifier with the given name exists in the registry.
     *
     * @param string $name The name of the notifiable event
     *
     * @return boolean True if notifier exists, false if not
     */
    public function hasNotifier($name);

    /**
     * Gets notifier by name.
     *
     * @param string $name The name of the notifier to be returned. Must exist in the registry
     *
     * @return \Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface The notifier requested
     */
    public function getNotifier($name);
}

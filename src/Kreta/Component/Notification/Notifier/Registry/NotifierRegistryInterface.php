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
 * Interface NotifierRegistryInterface
 *
 * @package Kreta\Component\Notification\Notifier\Registry
 */
interface NotifierRegistryInterface
{
    /**
     * Returns registered notifiers.
     *
     * @return NotifierInterface[] All registered notifiers.
     */
    public function getNotifiers();

    /**
     * Register notifier.
     *
     * @param string            $name     The name for the notifier.
     * @param NotifierInterface $notifier The notifier to be registered.
     */
    public function registerNotifier($name, NotifierInterface $notifier);

    /**
     * Unregister notifier.
     *
     * @param string $name The name of the notifier to be unregistered. Must exist in the registry.
     */
    public function unregisterNotifier($name);

    /**
     * Check if the notifier with the given name exists in the registry.
     *
     * @param string $name The name of the notifiable event.
     *
     * @return bool True if notifier exists, false if not.
     */
    public function hasNotifier($name);

    /**
     * Gets notifier by name
     *
     * @param string $name The name of the notifier to be returned. Must exist in the registry.
     *
     * @return NotifierInterface The notifier requested.
     */
    public function getNotifier($name);
} 

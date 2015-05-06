<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Notifier\Registry\Interfaces;

use Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface;

/**
 * Interface NotifierRegistryInterface.
 *
 * @package Kreta\Component\Notification\Notifier\Registry\Interfaces
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

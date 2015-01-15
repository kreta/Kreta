<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\NotifiableEvent\Registry\Interfaces;

use Kreta\Component\Notification\NotifiableEvent\Interfaces\NotifiableEventInterface;

/**
 * Interface NotifiableEventRegistryInterface.
 *
 * @package Kreta\Component\Notification\NotifiableEvent\Registry\Interfaces
 */
interface NotifiableEventRegistryInterface
{
    /**
     * Returns all registered notifiable events.
     *
     * @return NotifiableEventInterface[] All registered notifiable events
     */
    public function getNotifiableEvents();

    /**
     * Register notifiable event.
     *
     * @param string                                                                            $name            Name
     * @param \Kreta\Component\Notification\NotifiableEvent\Interfaces\NotifiableEventInterface $notifiableEvent Event
     */
    public function registerNotifiableEvent($name, NotifiableEventInterface $notifiableEvent);

    /**
     * Unregister notifiable event.
     *
     * @param string $name The name of the notifiable event to be unregistered. Must exist in the registry
     */
    public function unregisterNotifiableEvent($name);

    /**
     * Check if the notifiable event with the given name exists in the registry.
     *
     * @param string $name The name of the notifiable event
     *
     * @return boolean True if notifiable event exist, false if not
     */
    public function hasNotifiableEvent($name);

    /**
     * Gets notifiable event by name.
     *
     * @param string $name The name of the notifiable event to be returned. Must exist in the registry
     *
     * @return \Kreta\Component\Notification\NotifiableEvent\Interfaces\NotifiableEventInterface
     */
    public function getNotifiableEvent($name);
}

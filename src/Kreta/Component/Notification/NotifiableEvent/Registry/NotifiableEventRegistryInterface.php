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
 * Interface NotifiableEventRegistryInterface
 *
 * @package Kreta\Component\Notification\NotifiableEvent\Registry
 */
interface NotifiableEventRegistryInterface
{
    /**
     * Returns all registered notifiable events.
     *
     * @return NotifiableEventInterface[] All registered notifiable events.
     */
    public function getNotifiableEvents();

    /**
     * Register notifiable event
     *
     * @param string                   $name            The name for the notifiable event. Must be unique.
     * @param NotifiableEventInterface $NotifiableEvent The notifiable event to be registered.
     */
    public function registerNotifiableEvent($name, NotifiableEventInterface $NotifiableEvent);

    /**
     * Unregister notifiable event.
     *
     * @param string $name The name of the notifiable event to be unregistered. Must exist in the registry.
     */
    public function unregisterNotifiableEvent($name);

    /**
     * Check if the notifiable event with the given name exists in the registry.
     *
     * @param string $name The name of the notifiable event.
     *
     * @return bool True if notifiable event exist, false if not.
     */
    public function hasNotifiableEvent($name);

    /**
     * Gets notifiable event by name.
     *
     * @param string $name The name of the notifiable event to be returned. Must exist in the registry.
     *
     * @return NotifiableEventInterface The notifiable event requested.
     */
    public function getNotifiableEvent($name);
}

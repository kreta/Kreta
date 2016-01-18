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

namespace Kreta\Component\Notification\NotifiableEvent\Registry\Interfaces;

use Kreta\Component\Notification\NotifiableEvent\Interfaces\NotifiableEventInterface;

/**
 * Interface NotifiableEventRegistryInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\NotifiableEvent;

/**
 * Interface NotifiableEventInterface
 *
 * @package Kreta\Component\Notification\Event
 */
interface NotifiableEventInterface
{
    /**
     * @param string $event  Event that was triggered
     * @param object $object Entity that triggered the event
     *
     * @return bool Whether the event is supported or not
     */
    public function supportsEvent($event, $object);

    /**
     * @param string $event  Contains event that was triggered
     * @param object $object Object that triggered the event
     *
     * @return Kreta\Component\Notification\Model\Interfaces\NotificationInterface[]
     */
    public function getNotifications($event, $object);
} 

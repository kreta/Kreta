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

namespace Kreta\Component\Notification\NotifiableEvent\Interfaces;

/**
 * Interface NotifiableEventInterface.
 *
 * @package Kreta\Component\Notification\Event\Interfaces
 */
interface NotifiableEventInterface
{
    /**
     * Checks that event is supported by object passed.
     *
     * @param string $event  Event that was triggered
     * @param object $object Entity that triggered the event
     *
     * @return boolean
     */
    public function supportsEvent($event, $object);

    /**
     * Gets notifications.
     *
     * @param string $event  Contains event that was triggered
     * @param object $object Object that triggered the event
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface[]
     */
    public function getNotifications($event, $object);
}

<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Notifier\Interfaces;

use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;

/**
 * Interface NotifierInterface.
 *
 * @package Kreta\Component\Notification\Notifier\Interfaces
 */
interface NotifierInterface
{
    /**
     * Handles the notification and proceeds as required.
     *
     * @param \Kreta\Component\Notification\Model\Interfaces\NotificationInterface $notification Notification to be send
     */
    public function notify(NotificationInterface $notification);
}

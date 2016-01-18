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

namespace Kreta\Component\Notification\Notifier\Interfaces;

use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;

/**
 * Interface NotifierInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

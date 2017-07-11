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

declare(strict_types=1);

namespace Kreta\Notifier\Domain\ReadModel\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;

interface NotificationView
{
    public function notificationOfId(NotificationId $notificationId) : ?Notification;

    public function search($searchSpecification) : array;

    public function save(Notification $notification) : void;
}

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

interface NotificationSpecificationFactory
{
    public function createNotificationsOfUser(string $userId, int $from = 0, int $size = -1, string $status = null);
}

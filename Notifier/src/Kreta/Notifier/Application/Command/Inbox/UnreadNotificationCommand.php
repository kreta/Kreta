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

namespace Kreta\Notifier\Application\Command\Inbox;

class UnreadNotificationCommand
{
    private $notificationId;
    private $userId;

    public function __construct(string $notificationId, string $userId)
    {
        $this->notificationId = $notificationId;
        $this->userId = $userId;
    }

    public function notificationId() : string
    {
        return $this->notificationId;
    }

    public function userId() : string
    {
        return $this->userId;
    }
}

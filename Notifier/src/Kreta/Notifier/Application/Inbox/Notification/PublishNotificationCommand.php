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

namespace Kreta\Notifier\Application\Inbox\Notification;

use Kreta\SharedKernel\Domain\Model\Identity\Uuid;

class PublishNotificationCommand
{
    private $notificationId;
    private $body;
    private $userId;

    public function __construct(string $body, string $userId, string $notificationId = null)
    {
        $this->body = $body;
        $this->userId = $userId;
        $this->notificationId = $notificationId ?? Uuid::generate();
    }

    public function notificationId() : string
    {
        return $this->notificationId;
    }

    public function body() : string
    {
        return $this->body;
    }

    public function userId() : string
    {
        return $this->userId;
    }
}

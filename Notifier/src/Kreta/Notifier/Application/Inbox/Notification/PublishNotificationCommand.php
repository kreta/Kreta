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
    private $type;
    private $body;
    private $userId;

    public function __construct(string $type, string $body, string $userId, string $notificationId = null)
    {
        $this->type = $type;
        $this->body = $body;
        $this->userId = $userId;
        $this->notificationId = $notificationId ?? Uuid::generate();
    }

    public function notificationId() : string
    {
        return $this->notificationId;
    }

    public function type() : string
    {
        return $this->type;
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

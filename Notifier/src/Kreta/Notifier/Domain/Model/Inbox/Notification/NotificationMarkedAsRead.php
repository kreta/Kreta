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

namespace Kreta\Notifier\Domain\Model\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\SharedKernel\Domain\Model\DomainEvent;

class NotificationMarkedAsRead implements DomainEvent
{
    private $notificationId;
    private $status;
    private $userId;
    private $occurredOn;

    public function __construct(NotificationId $notificationId, UserId $userId)
    {
        $this->notificationId = $notificationId;
        $this->userId = $userId;
        $this->status = NotificationStatus::read();
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function notificationId() : NotificationId
    {
        return $this->notificationId;
    }

    public function userId() : UserId
    {
        return $this->userId;
    }

    public function status() : NotificationStatus
    {
        return $this->status;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

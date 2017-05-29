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

namespace Kreta\Notifier\Domain\Model\Inbox;

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class UserReceivedNotification implements DomainEvent
{
    private $userId;
    private $notificationId;
    private $body;
    private $occurredOn;

    public function __construct(UserId $userId, NotificationId $notificationId, NotificationBody $body)
    {
        $this->notificationId = $notificationId;
        $this->body = $body;
        $this->occurredOn = new \DateTimeImmutable();
        $this->userId = $userId;
    }

    public function userId() : UserId
    {
        return $this->userId;
    }

    public function notificationId() : NotificationId
    {
        return $this->notificationId;
    }

    public function body() : NotificationBody
    {
        return $this->body;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

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

namespace Kreta\Notifier\Domain\Model\Notification;

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class NotificationPublished implements DomainEvent
{
    private $id;
    private $owner;
    private $body;

    public function __construct(NotificationId $id, NotificationOwner $owner, NotificationBody $body)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->body = $body;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return new \DateTimeImmutable();
    }

    public function status() : NotificationStatus
    {
        return NotificationStatus::unread();
    }

    public function id() : NotificationId
    {
        return $this->id;
    }

    public function body() : NotificationBody
    {
        return $this->body;
    }

    public function owner() : NotificationOwner
    {
        return $this->owner;
    }
}

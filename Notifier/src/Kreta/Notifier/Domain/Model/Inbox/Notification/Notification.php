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
use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\Stream;

class Notification extends AggregateRoot implements EventSourcedAggregateRoot
{
    private $id;
    private $body;
    private $publishedOn;
    private $readOn;
    private $status;
    private $userId;

    private function __construct(NotificationId $id)
    {
        $this->id = $id;
    }

    public static function broadcast(NotificationId $id, UserId $userId, NotificationBody $body) : self
    {
        $notification = new self($id);

        $notification->publish(
            new NotificationPublished(
                $id,
                $userId,
                $body,
                NotificationStatus::unread()
            )
        );

        return $notification;
    }

    public function markAsRead() : void
    {
        $this->publish(
            new NotificationMarkedAsRead(
                $this->id,
                $this->userId
            )
        );
    }

    public function markAsUnread() : void
    {
        $this->publish(
            new NotificationMarkedAsUnread(
                $this->id,
                $this->userId
            )
        );
    }

    protected function applyNotificationPublished(NotificationPublished $event) : void
    {
        $this->body = $event->body();
        $this->userId = $event->userId();
        $this->publishedOn = $event->occurredOn();
        $this->status = $event->status();
    }

    protected function applyNotificationMarkedAsRead(NotificationMarkedAsRead $event) : void
    {
        $this->readOn = $event->occurredOn();
        $this->status = $event->status();
    }

    protected function applyNotificationMarkedAsUnread(NotificationMarkedAsUnread $event) : void
    {
        $this->readOn = null;
        $this->status = $event->status();
    }

    public static function reconstitute(Stream $stream) : self
    {
        $notification = new self($stream->name()->aggregateId());
        $events = $stream->events()->toArray();
        foreach ($events as $event) {
            $notification->apply($event);
        }

        return $notification;
    }

    public function id() : NotificationId
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return (string) $this->id()->id();
    }
}

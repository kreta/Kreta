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

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\EventStream;

class Notification extends AggregateRoot implements EventSourcedAggregateRoot
{
    private $id;
    private $body;
    private $owner;
    private $publishedOn;
    private $readOn;
    private $status;

    private function __construct(NotificationId $id)
    {
        $this->id = $id;
    }

    public static function broadcast(NotificationId $id, NotificationOwner $owner, NotificationBody $body) : self
    {
        $notification = new self($id);

        $notification->publish(
            new NotificationPublished($id, $owner, $body)
        );

        return $notification;
    }

    protected function applyThatNotificationPublished(NotificationPublished $event) : void
    {
        $this->body = $event->body();
        $this->owner = $event->owner();
        $this->publishedOn = $event->occurredOn();
        $this->status = $event->status();
    }

    protected function applyThatNotificationMarkedAsRead(NotificationMarkedAsRead $event) : void
    {
        $this->readOn = $event->occurredOn();
        $this->status = $event->status();
    }

    protected function applyThatNotificationMarkedAsUnread(NotificationMarkedAsUnread $event) : void
    {
        $this->readOn = null;
        $this->status = $event->status();
    }

    public static function reconstitute(EventStream $events) : AggregateRoot
    {
        $notification = new self($events->aggregateId());
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

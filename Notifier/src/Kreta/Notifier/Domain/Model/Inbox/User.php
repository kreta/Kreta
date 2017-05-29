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

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\EventStream;

class User extends AggregateRoot implements EventSourcedAggregateRoot
{
    private $id;
    private $notifications;

    private function __construct(UserId $id)
    {
        $this->id = $id;
        $this->notifications = new Notifications();
    }

    public static function signUp(UserId $id) : self
    {
        $instance = new self($id);
        $instance->publish(new UserSignedUp($id));

        return $instance;
    }

    public function receiveNotification(NotificationId $notificationId, NotificationBody $body) : void
    {
        $this->publish(
            new UserReceivedNotification(
                $this->id,
                $notificationId,
                $body
            )
        );
    }

    public function readNotification(Notification $notification) : void
    {
        $this->publish(
            new UserReadNotification($this->id, $notification->id())
        );
    }

    public function unreadNotification(Notification $notification) : void
    {
        $this->publish(
            new UserUnreadNotification($this->id, $notification->id())
        );
    }

    public function id() : UserId
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return (string) $this->id()->id();
    }

    public function notification(NotificationId $notificationId) : Notification
    {
        foreach ($this->notifications as $notification) {
            if ($notificationId->equals($notification->id())) {
                return $notification;
            }
        }

        throw new NotificationDoesNotExist();
    }

    protected function applyUserReceivedNotification(UserReceivedNotification $event) : void
    {
        $this->notifications->add(
            Notification::broadcast(
                $event->notificationId(),
                $event->body()
            )
        );
    }

    protected function applyUserReadNotification(UserReadNotification $event) : void
    {
        foreach ($this->notifications as $key => $notification) {
            if ($notification->id()->equals($event->notificationId())) {
                $this->notifications->of($key)->read();

                break;
            }
        }
    }

    protected function applyUserUnreadNotification(UserUnreadNotification $event) : void
    {
        foreach ($this->notifications as $key => $notification) {
            if ($notification->id()->equals($event->notificationId())) {
                $this->notifications->of($key)->unread();

                break;
            }
        }
    }

    public static function reconstitute(EventStream $stream) : EventSourcedAggregateRoot
    {
        $receiver = new self($stream->aggregateRootId());
        $events = $stream->events()->toArray();
        foreach ($events as $event) {
            $receiver->apply($event);
        }

        return $receiver;
    }
}

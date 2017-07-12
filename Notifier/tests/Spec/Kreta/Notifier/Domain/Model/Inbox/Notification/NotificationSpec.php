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

namespace Spec\Kreta\Notifier\Domain\Model\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationBody;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationMarkedAsRead;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationMarkedAsUnread;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationPublished;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationType;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\Stream;
use Kreta\SharedKernel\Event\StreamName;
use PhpSpec\ObjectBehavior;

class NotificationSpec extends ObjectBehavior
{
    function let(NotificationId $id, UserId $userId, NotificationType $type, NotificationBody $body)
    {
        $id->id()->willReturn('notification-id');
        $this->beConstructedBroadcast($id, $userId, $type, $body);
    }

    function it_can_be_broadcast(NotificationId $id)
    {
        $this->shouldHaveType(Notification::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->shouldImplement(EventSourcedAggregateRoot::class);
        $this->id()->shouldReturn($id);
        $id->id()->shouldBeCalled()->willReturn('notification-id');
        $this->__toString()->shouldReturn('notification-id');
        $this->shouldHavePublished(NotificationPublished::class);
    }

    function it_can_be_reconstituted_notification(
        Stream $stream,
        StreamName $streamName,
        NotificationId $id,
        NotificationPublished $notificationPublished,
        DomainEventCollection $collection
    ) {
        $collection->toArray()->shouldBeCalled()->willReturn([
            $notificationPublished,
        ]);
        $stream->events()->shouldBeCalled()->willReturn($collection);
        $stream->name()->shouldBeCalled()->willReturn($streamName);
        $streamName->aggregateId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->id()->shouldReturn($id);
        $id->id()->shouldBeCalled()->willReturn('notification-id');
        $this->__toString()->shouldReturn('notification-id');
    }

    function it_marks_as_read()
    {
        $this->markAsRead();
        $this->shouldHavePublished(NotificationMarkedAsRead::class);
    }

    function it_marks_as_unread()
    {
        $this->markAsUnread();
        $this->shouldHavePublished(NotificationMarkedAsUnread::class);
    }
}

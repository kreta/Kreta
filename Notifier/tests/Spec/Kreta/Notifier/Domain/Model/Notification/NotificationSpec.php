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

namespace Spec\Kreta\Notifier\Domain\Model\Notification;

use Kreta\Notifier\Domain\Model\Notification\Notification;
use Kreta\Notifier\Domain\Model\Notification\NotificationBody;
use Kreta\Notifier\Domain\Model\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Notification\NotificationMarkedAsRead;
use Kreta\Notifier\Domain\Model\Notification\NotificationMarkedAsUnread;
use Kreta\Notifier\Domain\Model\Notification\NotificationOwner;
use Kreta\Notifier\Domain\Model\Notification\NotificationPublished;
use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\EventStream;
use PhpSpec\ObjectBehavior;

class NotificationSpec extends ObjectBehavior
{
    function it_should_broadcast_notification(NotificationId $id, NotificationOwner $owner, NotificationBody $body)
    {
        $this->beConstructedBroadcast($id, $owner, $body);
        $this->shouldHaveType(Notification::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->shouldImplement(EventSourcedAggregateRoot::class);
        $this->shouldHavePublished(NotificationPublished::class);
        $this->id()->shouldReturn($id);
        $id->id()->shouldBeCalled()->willReturn('notification-id');
        $this->__toString()->shouldReturn('notification-id');
    }

    function it_should_reconstitute_notification(
        EventStream $stream,
        NotificationId $id,
        NotificationPublished $notificationPublished,
        DomainEventCollection $collection
    ) {
        $collection->toArray()->willReturn([
            $notificationPublished,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);

        $this->id()->shouldReturn($id);
        $id->id()->shouldBeCalled()->willReturn('notification-id');
        $this->__toString()->shouldReturn('notification-id');
    }

    function it_marks_as_read(
        EventStream $stream,
        NotificationId $id,
        NotificationPublished $notificationPublished,
        DomainEventCollection $collection
    ) {
        $collection->toArray()->willReturn([
            $notificationPublished,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->markAsRead();
        $this->shouldHavePublished(NotificationMarkedAsRead::class);
    }

    function it_marks_as_unread(
        EventStream $stream,
        NotificationId $id,
        NotificationPublished $notificationPublished,
        DomainEventCollection $collection
    ) {
        $collection->toArray()->willReturn([
            $notificationPublished,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->markAsUnread();
        $this->shouldHavePublished(NotificationMarkedAsUnread::class);
    }
}

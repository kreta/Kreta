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

namespace Spec\Kreta\Notifier\Domain\Model\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\Notification;
use Kreta\Notifier\Domain\Model\Inbox\NotificationBody;
use Kreta\Notifier\Domain\Model\Inbox\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserReadNotification;
use Kreta\Notifier\Domain\Model\Inbox\UserReceivedNotification;
use Kreta\Notifier\Domain\Model\Inbox\UserSignedUp;
use Kreta\Notifier\Domain\Model\Inbox\UserUnreadNotification;
use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\EventStream;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let(UserId $id)
    {
        $id->id()->willReturn('user-id');
        $this->beConstructedSignUp($id);
    }

    function it_can_be_signed_up()
    {
        $this->shouldHaveType(User::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->shouldImplement(EventSourcedAggregateRoot::class);
        $this->shouldHavePublished(UserSignedUp::class);
        $this->id()->shouldReturnAnInstanceOf(UserId::class);
        $this->__toString()->shouldReturn('user-id');
    }

    function it_can_be_reconstituted_user(
        EventStream $stream,
        UserId $id,
        UserSignedUp $userSignedUp,
        DomainEventCollection $collection
    ) {
        $collection->toArray()->willReturn([
            $userSignedUp,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->id()->shouldReturn($id);
        $id->id()->shouldBeCalled()->willReturn('user-id');
        $this->__toString()->shouldReturn('user-id');
    }

    function it_receives_notification(
        EventStream $stream,
        UserId $id,
        UserSignedUp $userSignedUp,
        DomainEventCollection $collection,
        NotificationId $notificationId,
        NotificationBody $body
    ) {
        $collection->toArray()->willReturn([
            $userSignedUp,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->receiveNotification($notificationId, $body);
        $this->shouldHavePublished(UserReceivedNotification::class);
    }

    function it_reads_notification(
        EventStream $stream,
        UserId $id,
        UserSignedUp $userSignedUp,
        DomainEventCollection $collection,
        Notification $notification,
        NotificationId $notificationId,
        UserReceivedNotification $userReceivedNotification
    ) {
        $collection->toArray()->willReturn([
            $userSignedUp,
            $userReceivedNotification,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $notification->id()->shouldBeCalled()->willReturn($notificationId);
        $this->readNotification($notification);
        $this->shouldHavePublished(UserReadNotification::class);
    }

    function it_unreads_notification(
        EventStream $stream,
        UserId $id,
        UserSignedUp $userSignedUp,
        DomainEventCollection $collection,
        Notification $notification,
        NotificationId $notificationId,
        UserReceivedNotification $userReceivedNotification,
        UserReadNotification $userReadNotification
    ) {
        $collection->toArray()->willReturn([
            $userSignedUp,
            $userReceivedNotification,
            $userReadNotification,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $notification->id()->shouldBeCalled()->willReturn($notificationId);
        $this->unreadNotification($notification);
        $this->shouldHavePublished(UserUnreadNotification::class);
    }

    function it_does_not_get_notification_when_it_does_not_exist(
        EventStream $stream,
        UserId $id,
        DomainEventCollection $collection,
        NotificationId $notificationId
    ) {
        $collection->toArray()->willReturn([]);
        $stream->events()->willReturn($collection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->shouldThrow(NotificationDoesNotExist::class)->duringNotification($notificationId);
    }

    function it_gets_notification(
        EventStream $stream,
        UserId $id,
        DomainEventCollection $collection,
        NotificationId $notificationId,
        NotificationId $notificationId2,
        NotificationBody $body,
        UserReadNotification $userReadNotification
    ) {
        $collection->toArray()->willReturn([]);
        $stream->events()->willReturn($collection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->receiveNotification($notificationId, $body);
        $userReadNotification->notificationId()->willReturn($notificationId);
        $notificationId2->equals($notificationId)->shouldBeCalled()->willReturn(true);
        $this->notification($notificationId2)->shouldReturnAnInstanceOf(Notification::class);
    }
}

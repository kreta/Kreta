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

namespace Spec\Kreta\Notifier\Domain\ReadEvent\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationBody;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationPublished;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationStatus;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationType;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\ReadEvent\Inbox\Notification\NotificationPublishedEventHandler;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationView;
use Kreta\SharedKernel\Domain\ReadEvent\EventHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationPublishedEventHandlerSpec extends ObjectBehavior
{
    function let(NotificationView $view)
    {
        $this->beConstructedWith($view);
    }

    function it_can_be_handle(
        NotificationPublished $event,
        NotificationView $view,
        NotificationId $notificationId,
        UserId $userId,
        NotificationType $type,
        NotificationBody $body,
        NotificationStatus $status,
        \DateTimeImmutable $occurredOn
    ) {
        $this->shouldHaveType(NotificationPublishedEventHandler::class);
        $this->shouldImplement(EventHandler::class);

        $event->notificationId()->shouldBeCalled()->willReturn($notificationId);
        $notificationId->id()->shouldBeCalled()->willReturn('notification-id');
        $event->userId()->shouldBeCalled()->willReturn($userId);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $event->type()->shouldBeCalled()->willReturn($type);
        $type->type()->shouldBeCalled()->willReturn('project_created');
        $event->body()->shouldBeCalled()->willReturn($body);
        $body->body()->shouldBeCalled()->willReturn('The notification body');
        $event->status()->shouldBeCalled()->willReturn($status);
        $status->status()->shouldBeCalled()->willReturn('unread');
        $event->occurredOn()->shouldBeCalled()->willReturn($occurredOn);
        $occurredOn->getTimestamp()->shouldBeCalled()->willReturn(2313312);

        $view->save(Argument::type(Notification::class))->shouldBeCalled();

        $this->handle($event);
    }

    function it_subscribes_to()
    {
        $this->isSubscribeTo()->shouldReturn(NotificationPublished::class);
    }
}

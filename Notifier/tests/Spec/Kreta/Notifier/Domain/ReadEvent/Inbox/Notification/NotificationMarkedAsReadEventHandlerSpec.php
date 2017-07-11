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

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationMarkedAsRead;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationStatus;
use Kreta\Notifier\Domain\ReadEvent\Inbox\Notification\NotificationMarkedAsReadEventHandler;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationView;
use Kreta\SharedKernel\Domain\ReadEvent\EventHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationMarkedAsReadEventHandlerSpec extends ObjectBehavior
{
    function let(NotificationView $view)
    {
        $this->beConstructedWith($view);
    }

    function it_can_be_handle(
        NotificationMarkedAsRead $event,
        NotificationView $view,
        Notification $notification,
        NotificationId $notificationId,
        NotificationStatus $status,
        \DateTimeImmutable $occurredOn
    ) {
        $this->shouldHaveType(NotificationMarkedAsReadEventHandler::class);
        $this->shouldImplement(EventHandler::class);

        $event->notificationId()->shouldBeCalled()->willReturn($notificationId);
        $view->notificationOfId($notificationId)->shouldBeCalled()->willReturn($notification);
        $event->status()->shouldBeCalled()->willReturn($status);
        $status->status()->shouldBeCalled()->willReturn('read');
        $event->occurredOn()->shouldBeCalled()->willReturn($occurredOn);
        $occurredOn->getTimestamp()->shouldBeCalled()->willReturn(2313312);

        $view->save(Argument::type(Notification::class))->shouldBeCalled();

        $this->handle($event);
    }

    function it_subscribes_to()
    {
        $this->isSubscribeTo()->shouldReturn(NotificationMarkedAsRead::class);
    }
}

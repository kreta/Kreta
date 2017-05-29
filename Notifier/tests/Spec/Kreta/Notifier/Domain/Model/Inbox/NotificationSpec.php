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
use Kreta\Notifier\Domain\Model\Inbox\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\NotificationStatus;
use PhpSpec\ObjectBehavior;

class NotificationSpec extends ObjectBehavior
{
    function let(NotificationId $id, NotificationBody $body)
    {
        $this->beConstructedBroadcast($id, $body);
    }

    function it_can_be_broadcast_notification(NotificationId $id, NotificationBody $body)
    {
        $this->shouldHaveType(Notification::class);
        $this->id()->shouldReturn($id);
        $this->body()->shouldReturn($body);
        $this->publishedOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->readOn()->shouldReturn(null);
        $this->status()->shouldReturnAnInstanceOf(NotificationStatus::class);
        $id->id()->shouldBeCalled()->willReturn('notification-id');
        $this->__toString()->shouldReturn('notification-id');
    }

    function it_can_be_managed_read_state()
    {
        $this->readOn()->shouldReturn(null);
        $this->read();
        $this->readOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->unread();
        $this->readOn()->shouldReturn(null);
    }
}

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

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationMarkedAsRead;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationStatus;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use PhpSpec\ObjectBehavior;

class NotificationMarkedAsReadSpec extends ObjectBehavior
{
    function it_should_be_created(NotificationId $notificationId, UserId $userId)
    {
        $this->beConstructedWith($notificationId, $userId);
        $this->shouldHaveType(NotificationMarkedAsRead::class);
        $this->shouldImplement(DomainEvent::class);
        $this->userId()->shouldReturn($userId);
        $this->notificationId()->shouldReturn($notificationId);
        $this->status()->shouldReturnAnInstanceOf(NotificationStatus::class);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

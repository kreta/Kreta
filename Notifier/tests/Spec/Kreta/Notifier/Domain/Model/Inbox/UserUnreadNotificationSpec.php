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

use Kreta\Notifier\Domain\Model\Inbox\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserUnreadNotification;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use PhpSpec\ObjectBehavior;

class UserUnreadNotificationSpec extends ObjectBehavior
{
    function it_should_be_created(UserId $userId, NotificationId $notificationId)
    {
        $this->beConstructedWith($userId, $notificationId);
        $this->shouldHaveType(UserUnreadNotification::class);
        $this->shouldImplement(DomainEvent::class);
        $this->userId()->shouldReturn($userId);
        $this->notificationId()->shouldReturn($notificationId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

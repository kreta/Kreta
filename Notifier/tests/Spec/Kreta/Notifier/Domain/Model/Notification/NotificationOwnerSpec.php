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

use Kreta\Notifier\Domain\Model\Notification\NotificationOwnerId;
use Kreta\Notifier\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class NotificationOwnerSpec extends ObjectBehavior
{
    function it_creates_a_notification_owner(NotificationOwnerId $id, UserId $userId)
    {
        $this->beConstructedWith($id, $userId);
        $this->id()->shouldReturn($id);
        $this->userId()->shouldReturn($userId);
        $id->id()->shouldBeCalled()->willReturn('notification-owner-id');
        $this->__toString()->shouldReturn('notification-owner-id');
    }
}

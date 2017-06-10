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

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationAlreadyExists;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\SharedKernel\Domain\Model\Exception;
use PhpSpec\ObjectBehavior;

class NotificationAlreadyExistsSpec extends ObjectBehavior
{
    function let(NotificationId $notificationId)
    {
        $this->beConstructedWith($notificationId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NotificationAlreadyExists::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message(NotificationId $notificationId)
    {
        $notificationId->id()->shouldBeCalled()->willReturn('notification-id');
        $this->getMessage()->shouldReturn('Already exists a notification with the "notification-id" id');
    }
}

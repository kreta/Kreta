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

namespace Spec\Kreta\Notifier\Application\Inbox\Notification;

use Kreta\Notifier\Application\Inbox\Notification\PublishNotificationCommand;
use PhpSpec\ObjectBehavior;

class PublishNotificationCommandSpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('The notification body', 'user-id', 'notification-id');
        $this->shouldHaveType(PublishNotificationCommand::class);
        $this->notificationId()->shouldReturn('notification-id');
        $this->body()->shouldReturn('The notification body');
        $this->userId()->shouldReturn('user-id');
    }

    function it_can_be_created_without_notification_id()
    {
        $this->beConstructedWith('The notification body', 'user-id');
        $this->shouldHaveType(PublishNotificationCommand::class);
        $this->notificationId()->shouldNotReturn(null);
        $this->body()->shouldReturn('The notification body');
        $this->userId()->shouldReturn('user-id');
    }
}

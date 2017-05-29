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
use Kreta\Notifier\Domain\Model\Inbox\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\Notifications;
use PhpSpec\ObjectBehavior;

class NotificationsSpec extends ObjectBehavior
{
    function it_can_be_created(Notification $notification)
    {
        $this->shouldHaveType(Notifications::class);
        $this->count()->shouldReturn(0);
        $this->add($notification);
        $this->count()->shouldReturn(1);
        $this->of(0)->shouldReturn($notification);
        $this->getIterator()->shouldReturnAnInstanceOf(\ArrayIterator::class);
    }

    function it_does_not_get_notification_when_it_does_not_exist()
    {
        $this->shouldThrow(NotificationDoesNotExist::class)->duringOf(0);
    }
}

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

use Kreta\Notifier\Domain\Model\Notification\NotificationType;
use Kreta\Notifier\Domain\Model\Notification\NotificationTypeNotAllowedException;
use PhpSpec\ObjectBehavior;

class NotificationTypeSpec extends ObjectBehavior
{
    function it_does_not_create_notification_type_with_invalid_type()
    {
        $this->beConstructedWith('invalid-notification-type');
        $this->shouldThrow(NotificationTypeNotAllowedException::class)->duringInstantiation();
    }

    function it_creates_a_read_notification_type_value()
    {
        $this->beConstructedRead();
        $this->type()->shouldReturn(NotificationType::READ);
        $this->__toString()->shouldReturn(NotificationType::READ);
    }

    function it_creates_a_unread_notification_type_value()
    {
        $this->beConstructedUnread();
        $this->type()->shouldReturn(NotificationType::UNREAD);
        $this->__toString()->shouldReturn(NotificationType::UNREAD);
    }
}

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

use Kreta\Notifier\Domain\Model\Inbox\NotificationStatusNotAllowed;
use PhpSpec\ObjectBehavior;

class NotificationStatusSpec extends ObjectBehavior
{
    private const READ = 'read';
    private const UNREAD = 'unread';

    function it_does_not_create_notification_status_with_invalid_status()
    {
        $this->beConstructedWith('invalid-notification-status');
        $this->shouldThrow(NotificationStatusNotAllowed::class)->duringInstantiation();
    }

    function it_creates_a_read_notification_status_value()
    {
        $this->beConstructedRead();
        $this->status()->shouldReturn(self::READ);
        $this->__toString()->shouldReturn(self::READ);
    }

    function it_creates_a_unread_notification_status_value()
    {
        $this->beConstructedUnread();
        $this->status()->shouldReturn(self::UNREAD);
        $this->__toString()->shouldReturn(self::UNREAD);
    }
}

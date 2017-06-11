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

use Kreta\Notifier\Application\Inbox\Notification\ViewUserNotificationsQuery;
use PhpSpec\ObjectBehavior;

class ViewUserNotificationsQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id', 0, 10);
        $this->shouldHaveType(ViewUserNotificationsQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(10);
        $this->status()->shouldReturn(null);
    }

    function it_can_be_created_with_status()
    {
        $this->beConstructedWith('user-id', 0, 10, 'read');
        $this->shouldHaveType(ViewUserNotificationsQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(10);
        $this->status()->shouldReturn('read');
    }
}

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

use Kreta\Notifier\Application\Inbox\Notification\ViewUserNotifications;
use Kreta\Notifier\Application\Inbox\Notification\ViewUserNotificationsQuery;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationSpecificationFactory;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationView;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ViewUserNotificationsSpec extends ObjectBehavior
{
    function it_can_be_search(
        NotificationView $view,
        NotificationSpecificationFactory $specificationFactory,
        ViewUserNotificationsQuery $query
    ) {
        $this->beConstructedWith($view, $specificationFactory);
        $this->shouldHaveType(ViewUserNotifications::class);

        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->limit()->shouldBeCalled()->willReturn(50);
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->status()->shouldBeCalled()->willReturn('read');

        $specificationFactory->createNotificationsOfUser('user-id', 0, 50, 'read')->shouldBeCalled();
        $view->search(Argument::any())->shouldBeCalled()->willReturn([]);

        $this->__invoke($query)->shouldBeArray();
    }
}

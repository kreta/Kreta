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

namespace Spec\Kreta\Notifier\Application\Command\Notification;

use Kreta\Notifier\Application\Command\Notification\MarkAsUnreadNotificationCommand;
use PhpSpec\ObjectBehavior;

class MarkAsUnreadNotificationCommandSpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('notification-id', 'user-id');
        $this->shouldHaveType(MarkAsUnreadNotificationCommand::class);
        $this->id()->shouldReturn('notification-id');
        $this->userId()->shouldReturn('user-id');
    }
}

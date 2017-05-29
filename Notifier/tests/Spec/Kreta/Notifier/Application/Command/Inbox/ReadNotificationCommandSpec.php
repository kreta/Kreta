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

namespace Spec\Kreta\Notifier\Application\Command\Inbox;

use Kreta\Notifier\Application\Command\Inbox\ReadNotificationCommand;
use PhpSpec\ObjectBehavior;

class ReadNotificationCommandSpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('notification-id', 'user-id');
        $this->shouldHaveType(ReadNotificationCommand::class);
        $this->notificationId()->shouldReturn('notification-id');
        $this->userId()->shouldReturn('user-id');
    }
}

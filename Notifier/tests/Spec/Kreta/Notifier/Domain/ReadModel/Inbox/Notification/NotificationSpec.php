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

namespace Spec\Kreta\Notifier\Domain\ReadModel\Inbox\Notification;

use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\Notification;
use PhpSpec\ObjectBehavior;

class NotificationSpec extends ObjectBehavior
{
    function it_can_be_built()
    {
        $this->beConstructedWith('notification-id', 'user-id', 'The notification body', 638323200, 'unread');
        $this->shouldHaveType(Notification::class);
        $this->shouldImplement(\JsonSerializable::class);
        $this->jsonSerialize()->shouldReturn([
            'id'           => 'notification-id',
            'user_id'      => 'user-id',
            'body'         => 'The notification body',
            'published_on' => 638323200,
            'status'       => 'unread',
            'read_on'      => null,
        ]);
    }

    function it_can_be_built_with_read_on()
    {
        $this->beConstructedWith('notification-id', 'user-id', 'The notification body', 638323200, 'read', 238343200);
        $this->shouldHaveType(Notification::class);
        $this->shouldImplement(\JsonSerializable::class);
        $this->jsonSerialize()->shouldReturn([
            'id'           => 'notification-id',
            'user_id'      => 'user-id',
            'body'         => 'The notification body',
            'published_on' => 638323200,
            'status'       => 'read',
            'read_on'      => 238343200,
        ]);
    }

    function it_can_be_built_from_array()
    {
        $this->beConstructedFromArray([
            'id'           => 'notification-id',
            'user_id'      => 'user-id',
            'body'         => 'The notification body',
            'published_on' => 638323200,
            'status'       => 'unread',
            'read_on'      => null,
        ]);
        $this->jsonSerialize()->shouldReturn([
            'id'           => 'notification-id',
            'user_id'      => 'user-id',
            'body'         => 'The notification body',
            'published_on' => 638323200,
            'status'       => 'unread',
            'read_on'      => null,
        ]);
    }
}

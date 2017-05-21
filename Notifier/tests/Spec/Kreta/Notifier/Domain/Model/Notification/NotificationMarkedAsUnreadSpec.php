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

use Kreta\Notifier\Domain\Model\Notification\NotificationMarkedAsUnread;
use Kreta\Notifier\Domain\Model\Notification\NotificationStatus;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use PhpSpec\ObjectBehavior;

class NotificationMarkedAsUnreadSpec extends ObjectBehavior
{
    function it_should_be_created()
    {
        $this->shouldHaveType(NotificationMarkedAsUnread::class);
        $this->shouldImplement(DomainEvent::class);
        $this->status()->shouldReturnAnInstanceOf(NotificationStatus::class);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

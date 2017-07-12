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

namespace Spec\Kreta\Notifier\Domain\Model\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationType;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationTypeIsNotValid;
use PhpSpec\ObjectBehavior;

class NotificationTypeSpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedwith('project_created');
        $this->shouldHaveType(NotificationType::class);
        $this->type()->shouldReturn('project_created');
        $this->__toString()->shouldReturn('project_created');
    }

    function it_can_be_created_with_invalid_type()
    {
        $this->beConstructedwith('not_valid_type');
        $this->shouldThrow(NotificationTypeIsNotValid::class)->duringInstantiation();
    }
}

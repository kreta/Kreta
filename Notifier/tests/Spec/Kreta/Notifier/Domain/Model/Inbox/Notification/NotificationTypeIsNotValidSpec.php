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

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationTypeIsNotValid;
use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class NotificationTypeIsNotValidSpec extends ObjectBehavior
{
    function it_can_be_thrown()
    {
        $this->beConstructedWith('not_valid_type');
        $this->shouldHaveType(NotificationTypeIsNotValid::class);
        $this->shouldHaveType(InvalidArgumentException::class);
        $this->getMessage()->shouldReturn('The given "not_valid_type" notification type is not valid');
    }
}

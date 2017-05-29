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

use Kreta\Notifier\Domain\Model\Inbox\NotificationBodyIsEmpty;
use PhpSpec\ObjectBehavior;

class NotificationBodySpec extends ObjectBehavior
{
    function it_does_not_create_notification_body_without_body()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(NotificationBodyIsEmpty::class)->duringInstantiation();
    }

    function it_creates_a_notification_body()
    {
        $this->beConstructedWith('The notification body');
        $this->body()->shouldReturn('The notification body');
        $this->__toString()->shouldReturn('The notification body');
    }
}

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

use Kreta\Notifier\Application\Command\Inbox\SignUpUserCommand;
use PhpSpec\ObjectBehavior;

class SignUpUserCommandSpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id');
        $this->shouldHaveType(SignUpUserCommand::class);
        $this->userId()->shouldReturn('user-id');
    }
}

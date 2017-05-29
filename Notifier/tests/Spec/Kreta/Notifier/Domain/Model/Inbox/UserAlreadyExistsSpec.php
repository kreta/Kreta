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

use Kreta\Notifier\Domain\Model\Inbox\UserAlreadyExists;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\SharedKernel\Domain\Model\Exception;
use PhpSpec\ObjectBehavior;

class UserAlreadyExistsSpec extends ObjectBehavior
{
    function let(UserId $userId)
    {
        $this->beConstructedWith($userId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserAlreadyExists::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message(UserId $userId)
    {
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $this->getMessage()->shouldReturn('Already exists a user with the "user-id" id');
    }
}

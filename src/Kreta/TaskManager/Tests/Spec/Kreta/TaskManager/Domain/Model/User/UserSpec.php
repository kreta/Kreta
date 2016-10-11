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

namespace Spec\Kreta\TaskManager\Domain\Model\User;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\Identity\Username;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Validator\Constraints\Email;

class UserSpec extends ObjectBehavior
{
    function let(UserId $id, Email $email, Username $username)
    {
        $id->id()->willReturn('user-id');
        $this->beConstructedWith($id, $email, $username);
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(User::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->id()->shouldReturnAnInstanceOf(UserId::class);
        $this->email()->shouldReturnAnInstanceOf(Email::class);
        $this->username()->shouldReturnAnInstanceOf(Username::class);
        $this->__toString()->shouldReturn('user-id');
    }
}

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

namespace Spec\Kreta\TaskManager\Domain\Model\User;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let(UserId $id)
    {
        $id->id()->willReturn('user-id');
        $this->beConstructedWith($id);
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(User::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->id()->shouldReturnAnInstanceOf(UserId::class);
        $this->__toString()->shouldReturn('user-id');
    }
}

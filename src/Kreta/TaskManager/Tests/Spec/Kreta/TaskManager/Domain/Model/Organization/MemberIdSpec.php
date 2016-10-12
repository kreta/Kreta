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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class MemberIdSpec extends ObjectBehavior
{
    function let(UserId $userId)
    {
        $userId->id()->willReturn('user-id');
        $this->beConstructedGenerate($userId, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MemberId::class);
    }

    function it_generates(UserId $userId)
    {
        $this::generate($userId, 1)->shouldReturnAnInstanceOf(MemberId::class);
        $this->id()->shouldReturn(1);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $this->__toString()->shouldReturn('Id: 1, UserId: user-id');
    }

    function it_compares_two_ids_that_do_not_equals(MemberId $memberId, UserId $userId2)
    {
        $memberId->id()->shouldBeCalled()->willReturn(1);
        $memberId->userId()->shouldBeCalled()->willReturn($userId2);
        $userId2->id()->shouldBeCalled()->willReturn('not-user-id');
        $this->equals($memberId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_do_not_equals_for_id(MemberId $memberId)
    {
        $memberId->id()->shouldBeCalled()->willReturn(2);
        $this->equals($memberId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_are_equals(MemberId $memberId, UserId $userId)
    {
        $memberId->id()->shouldBeCalled()->willReturn(1);
        $memberId->userId()->shouldBeCalled()->willReturn($userId);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $this->equals($memberId)->shouldReturn(true);
    }
}

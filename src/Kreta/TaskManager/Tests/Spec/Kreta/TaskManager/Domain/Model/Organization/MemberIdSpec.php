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
use Kreta\TaskManager\Tests\Double\Domain\Model\MemberIdStub;
use PhpSpec\ObjectBehavior;

class MemberIdSpec extends ObjectBehavior
{
    function let(UserId $userId)
    {
        $this->beAnInstanceOf(MemberIdStub::class);
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

    function it_compares_two_ids_that_do_not_equals(MemberId $participantId, UserId $userId2)
    {
        $participantId->id()->shouldBeCalled()->willReturn(1);
        $participantId->userId()->shouldBeCalled()->willReturn($userId2);
        $userId2->id()->shouldBeCalled()->willReturn('not-user-id');
        $this->equals($participantId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_do_not_equals_for_id(MemberId $participantId)
    {
        $participantId->id()->shouldBeCalled()->willReturn(2);
        $this->equals($participantId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_are_equals(MemberId $participantId, UserId $userId)
    {
        $participantId->id()->shouldBeCalled()->willReturn(1);
        $participantId->userId()->shouldBeCalled()->willReturn($userId);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $this->equals($participantId)->shouldReturn(true);
    }
}

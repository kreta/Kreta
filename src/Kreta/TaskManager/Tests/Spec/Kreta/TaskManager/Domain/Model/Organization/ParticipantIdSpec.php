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

use Kreta\TaskManager\Domain\Model\Organization\ParticipantId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Tests\Double\Domain\Model\ParticipantIdStub;
use PhpSpec\ObjectBehavior;

class ParticipantIdSpec extends ObjectBehavior
{
    function let(UserId $userId)
    {
        $this->beAnInstanceOf(ParticipantIdStub::class);
        $userId->id()->willReturn('user-id');
        $this->beConstructedGenerate($userId, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ParticipantId::class);
    }

    function it_generates(UserId $userId)
    {
        $this::generate($userId, 1)->shouldReturnAnInstanceOf(ParticipantId::class);
        $this->id()->shouldReturn(1);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $this->__toString()->shouldReturn('Id: 1, UserId: user-id');
    }

    function it_compares_two_ids_that_do_not_equals(ParticipantId $participantId, UserId $userId2)
    {
        $participantId->id()->shouldBeCalled()->willReturn(1);
        $participantId->userId()->shouldBeCalled()->willReturn($userId2);
        $userId2->id()->shouldBeCalled()->willReturn('not-user-id');
        $this->equals($participantId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_do_not_equals_for_id(ParticipantId $participantId)
    {
        $participantId->id()->shouldBeCalled()->willReturn(2);
        $this->equals($participantId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_are_equals(ParticipantId $participantId, UserId $userId)
    {
        $participantId->id()->shouldBeCalled()->willReturn(1);
        $participantId->userId()->shouldBeCalled()->willReturn($userId);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $this->equals($participantId)->shouldReturn(true);
    }
}

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

use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Tests\Double\Domain\Model\Organization\MemberStub;
use PhpSpec\ObjectBehavior;

class MemberSpec extends ObjectBehavior
{
    function let(MemberId $id, UserId $userId, Organization $organization)
    {
        $this->beAnInstanceOf(MemberStub::class);
        $id->id()->willReturn('member-id');
        $this->beConstructedWith($id, $userId, $organization);
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(Member::class);
        $this->id()->shouldReturnAnInstanceOf(MemberId::class);
        $this->userId()->shouldReturnAnInstanceOf(UserId::class);
        $this->organization()->shouldReturnAnInstanceOf(Organization::class);
        $this->createdOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->updatedOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->__toString()->shouldReturn('member-id');
    }
}

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
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class MemberIdSpec extends ObjectBehavior
{
    function let(UserId $userId, OrganizationId $organizationId)
    {
        $userId->id()->willReturn('user-id');
        $organizationId->id()->willReturn('organization-id');
        $this->beConstructedGenerate($userId, $organizationId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MemberId::class);
    }

    function it_renders_to_string()
    {
        $this->__toString()->shouldReturn('UserId: user-id, OrganizationId: organization-id');
    }

    function it_compares_two_ids_that_are_not_equal(MemberId $memberId, UserId $userId2, OrganizationId $organizationId)
    {
        $memberId->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $memberId->userId()->shouldBeCalled()->willReturn($userId2);
        $this->equals($memberId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_do_not_have_same_organization_id(MemberId $memberId, OrganizationId $organizationId2)
    {
        $memberId->organizationId()->shouldBeCalled()->willReturn($organizationId2);
        $this->equals($memberId)->shouldReturn(false);
    }

    function it_compares_two_ids_that_are_equals(MemberId $memberId, UserId $userId, OrganizationId $organizationId)
    {
        $memberId->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $memberId->userId()->shouldBeCalled()->willReturn($userId);
        $this->equals($memberId)->shouldReturn(true);
    }
}

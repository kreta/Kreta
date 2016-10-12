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

use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberId;
use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Tests\Double\Domain\Model\MemberStub;
use PhpSpec\ObjectBehavior;

class MemberSpec extends ObjectBehavior
{
    function let(OrganizationMemberId $id)
    {
        $id->id()->willReturn('organization-participant-id');
        $this->beAnInstanceOf(MemberStub::class);
        $this->beConstructedWith($id);
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(Member::class);
        $this->id()->shouldReturnAnInstanceOf(OrganizationMemberId::class);
        $this->__toString()->shouldReturn('organization-participant-id');
    }
}

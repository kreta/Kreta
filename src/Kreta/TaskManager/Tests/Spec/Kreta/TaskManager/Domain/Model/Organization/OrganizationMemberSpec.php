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
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMember;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class OrganizationMemberSpec extends ObjectBehavior
{
    function let(OrganizationMemberId $id, UserId $userId, Organization $organization)
    {
        $this->beConstructedWith($id, $userId, $organization);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationMember::class);
        $this->shouldHaveType(Member::class);
    }
}

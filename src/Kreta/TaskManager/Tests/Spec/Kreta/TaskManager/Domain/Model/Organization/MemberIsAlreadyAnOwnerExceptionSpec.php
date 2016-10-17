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

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\MemberIsAlreadyAnOwnerException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class MemberIsAlreadyAnOwnerExceptionSpec extends ObjectBehavior
{
    function let(MemberId $memberId, UserId $userId, OrganizationId $organizationId)
    {
        $memberId->userId()->willReturn($userId);
        $memberId->organizationId()->willReturn($organizationId);
        $userId->id()->willReturn('user-id');
        $organizationId->id()->willReturn('organization-id');
        $this->beConstructedWith($memberId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MemberIsAlreadyAnOwnerException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('The given user-id user is already an owner in organization-id organization');
    }
}
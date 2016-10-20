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

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\MemberAdded;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class MemberAddedSpec extends ObjectBehavior
{
    function let(MemberId $memberId, UserId $userId, OrganizationId $organizationId)
    {
        $this->beConstructedWith($memberId, $userId, $organizationId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MemberAdded::class);
        $this->shouldImplement(DomainEvent::class);
    }

    function it_can_be_created(MemberId $memberId, UserId $userId, OrganizationId $organizationId)
    {
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
        $this->organizationId()->shouldReturn($organizationId);
        $this->memberId()->shouldReturn($memberId);
        $this->userId()->shouldReturn($userId);
    }
}

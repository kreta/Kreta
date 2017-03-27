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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\Collection;
use Kreta\SharedKernel\Domain\Model\CollectionElementAlreadyRemovedException;
use Kreta\TaskManager\Domain\Model\Organization\MemberCollection;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Tests\Double\Domain\Model\Organization\MemberCollectionStub;
use Kreta\TaskManager\Tests\Double\Domain\Model\Organization\MemberStub;
use PhpSpec\ObjectBehavior;

class MemberCollectionSpec extends ObjectBehavior
{
    function let(MemberStub $member, UserId $userId)
    {
        $this->beAnInstanceOf(MemberCollectionStub::class);
        $member->userId()->willReturn($userId);
        $this->add($member);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MemberCollection::class);
        $this->shouldHaveType(Collection::class);
    }

    function it_contains_user_id(MemberStub $member, UserId $userId)
    {
        $member->userId()->shouldBeCalled()->willReturn($userId);
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->containsUserId($userId)->shouldReturn(true);
    }

    function it_does_not_contain_user_id(MemberStub $member, UserId $userId, UserId $userId2)
    {
        $member->userId()->shouldBeCalled()->willReturn($userId2);
        $userId->equals($userId2)->shouldBeCalled()->willReturn(false);
        $this->containsUserId($userId)->shouldReturn(false);
    }

    function it_removes_by_user_id(MemberStub $member, UserId $userId)
    {
        $member->userId()->shouldBeCalled()->willReturn($userId);
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $member->removeOrganization()->shouldBeCalled();
        $this->removeByUserId($userId);
    }

    function it_does_not_remove_by_user_id(MemberStub $member, UserId $userId, UserId $userId2)
    {
        $member->userId()->shouldBeCalled()->willReturn($userId2);
        $userId->equals($userId2)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(CollectionElementAlreadyRemovedException::class)->duringRemoveByUserId($userId);
    }
}

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

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\CollectionElementAlreadyAddedException;
use Kreta\SharedKernel\Domain\Model\CollectionElementAlreadyRemovedException;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Organization\MemberAdded;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\MemberRemoved;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationCreated;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationEdited;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerAdded;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Organization\OwnerRemoved;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedRemoveOwnerException;
use PhpSpec\ObjectBehavior;

class OrganizationSpec extends ObjectBehavior
{
    function let(OrganizationId $id, OrganizationName $name, Slug $slug, Owner $owner, OwnerId $ownerId)
    {
        $id->id()->willReturn('organization-id');
        $owner->id()->willReturn($ownerId);
        $this->beConstructedWith($id, $name, $slug, $owner);
        $this->shouldHavePublished(OrganizationCreated::class);
    }

    function it_can_be_created(Owner $owner, OrganizationName $name, Slug $slug)
    {
        $this->shouldHaveType(Organization::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->id()->shouldReturnAnInstanceOf(OrganizationId::class);
        $this->__toString()->shouldReturn('organization-id');
        $this->name()->shouldReturn($name);
        $this->slug()->shouldReturn($slug);
        $this->createdOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->updatedOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->owners()->shouldReturnCollection([$owner]);
    }

    function it_can_be_edited(OrganizationName $name, OrganizationName $name2, Slug $slug, Slug $slug2)
    {
        $this->name()->shouldReturn($name);
        $this->slug()->shouldReturn($slug);
        $this->edit($name2, $slug2);
        $this->shouldHavePublished(OrganizationEdited::class);

        $this->name()->shouldReturn($name2);
        $this->slug()->shouldReturn($slug2);
    }

    function it_allows_adding_a_new_owner(Owner $owner, Owner $owner2, OwnerId $ownerId)
    {
        $this->owners()->shouldReturnCollection([$owner]);
        $owner2->id()->shouldBeCalled()->willReturn($ownerId);
        $this->addOwner($owner2);
        $this->shouldHavePublished(OwnerAdded::class);
        $this->owners()->shouldReturnCollection([$owner, $owner2]);
    }

    function it_does_not_allow_to_add_existing_owner(Owner $owner)
    {
        $this->shouldThrow(CollectionElementAlreadyAddedException::class)->during('addOwner', [$owner]);
    }

    function it_allows_removing_an_owner(Owner $owner, Owner $owner2, OwnerId $ownerId)
    {
        $owner2->id()->shouldBeCalled()->willReturn($ownerId);
        $this->addOwner($owner2);
        $this->shouldHavePublished(OwnerAdded::class);
        $this->removeOwner($owner2);
        $this->shouldHavePublished(OwnerRemoved::class);
        $this->owners()->shouldReturnCollection([$owner]);
    }

    function it_does_not_allow_removing_unexistent_owner(Owner $owner2, Owner $owner3, OwnerId $ownerId)
    {
        $owner2->id()->shouldBeCalled()->willReturn($ownerId);
        $this->addOwner($owner2);
        $this->shouldThrow(CollectionElementAlreadyRemovedException::class)->during('removeOwner', [$owner3]);
    }

    function it_allows_adding_a_new_member(Member $member, MemberId $memberId)
    {
        $member->id()->shouldBeCalled()->willReturn($memberId);
        $this->addMember($member);
        $this->shouldHavePublished(MemberAdded::class);
        $this->members()->shouldReturnCollection([$member]);
    }

    function it_does_not_allow_to_add_existing_member(Member $member, MemberId $memberId)
    {
        $member->id()->shouldBeCalled()->willReturn($memberId);
        $this->addMember($member);
        $this->shouldHavePublished(MemberAdded::class);
        $this->shouldThrow(CollectionElementAlreadyAddedException::class)->during('addMember', [$member]);
    }

    function it_allows_removing_a_member(Member $member, MemberId $memberId)
    {
        $member->id()->shouldBeCalled()->willReturn($memberId);
        $this->addMember($member);
        $this->shouldHavePublished(MemberAdded::class);
        $this->removeMember($member);
        $this->shouldHavePublished(MemberRemoved::class);
    }

    function it_does_not_allow_removing_unexistent_member(Member $member)
    {
        $this->shouldThrow(CollectionElementAlreadyRemovedException::class)->during('removeMember', [$member]);
    }

    function it_does_not_remove_owner_because_all_the_organizations_need_one_owner_at_least(Owner $owner)
    {
        $this->shouldThrow(UnauthorizedRemoveOwnerException::class)->during('removeOwner', [$owner]);
    }

    function it_checks_if_it_is_owner(OwnerId $ownerId, Owner $owner, OwnerId $ownerId2)
    {
        $this->owners()->shouldReturnCollection([$owner]);
        $owner->id()->shouldBeCalled()->willReturn($ownerId);
        $ownerId->equals($ownerId)->shouldBeCalled()->willReturn(true);
        $this->isOwner($ownerId)->shouldReturn(true);

        $this->owners()->shouldReturnCollection([$owner]);
        $owner->id()->shouldBeCalled()->willReturn($ownerId2);
        $ownerId->equals($ownerId2)->shouldBeCalled()->willReturn(false);
        $this->isOwner($ownerId)->shouldReturn(false);
    }

    function it_checks_if_it_is_member(
        OwnerId $ownerId,
        Owner $owner,
        OwnerId $ownerId2,
        Member $member,
        MemberId $memberId,
        MemberId $memberId2
    ) {
        $this->owners()->shouldReturnCollection([$owner]);
        $owner->id()->shouldBeCalled()->willReturn($ownerId);
        $ownerId->equals($ownerId)->shouldBeCalled()->willReturn(true);
        $this->isMember($ownerId)->shouldReturn(true);

        $this->owners()->shouldReturnCollection([$owner]);
        $owner->id()->shouldBeCalled()->willReturn($ownerId2);
        $ownerId->equals($ownerId2)->shouldBeCalled()->willReturn(false);
        $this->isMember($ownerId)->shouldReturn(false);

        $member->id()->shouldBeCalled()->willReturn($memberId);
        $this->addMember($member);
        $this->members()->shouldReturnCollection([$member]);

        $member->id()->shouldBeCalled()->willReturn($memberId);
        $memberId->equals($memberId)->shouldBeCalled()->willReturn(true);
        $this->isMember($memberId)->shouldReturn(true);

        $member->id()->shouldBeCalled()->willReturn($memberId);
        $memberId2->equals($memberId)->shouldBeCalled()->willReturn(false);
        $owner->id()->shouldBeCalled()->willReturn($ownerId);
        $memberId2->equals($ownerId)->shouldBeCalled()->willReturn(false);
        $this->isMember($memberId2)->shouldReturn(false);
    }
}

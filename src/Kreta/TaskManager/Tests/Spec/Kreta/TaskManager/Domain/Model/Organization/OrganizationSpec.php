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
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationCreated;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationEdited;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberAdded;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberIsAlreadyAnOwnerException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberRemoved;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerAdded;
use Kreta\TaskManager\Domain\Model\Organization\OwnerRemoved;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedRemoveOwnerException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class OrganizationSpec extends ObjectBehavior
{
    function let(OrganizationId $id, OrganizationName $name, Slug $slug, UserId $userId)
    {
        $id->id()->willReturn('organization-id');
        $this->beConstructedWith($id, $name, $slug, $userId);
        $this->shouldHavePublished(OrganizationCreated::class);
    }

    function it_can_be_created(OrganizationName $name, Slug $slug)
    {
        $this->shouldHaveType(Organization::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->id()->shouldReturnAnInstanceOf(OrganizationId::class);
        $this->__toString()->shouldReturn('organization-id');
        $this->name()->shouldReturn($name);
        $this->slug()->shouldReturn($slug);
        $this->createdOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->updatedOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->owners()->shouldHaveCount(1);
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

    function it_allows_adding_a_new_owner(UserId $userId, UserId $userId2)
    {
        $this->owners()->shouldHaveCount(1);
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->isOwner($userId)->shouldReturn(true);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->addOwner($userId2);
        $this->shouldHavePublished(OwnerAdded::class);
        $this->owners()->shouldHaveCount(2);
    }

    function it_allows_grant_organization_member_to_owner(UserId $userId, UserId $userId2)
    {
        $this->organizationMembers()->shouldHaveCount(0);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->isOwner($userId2)->shouldReturn(false);
        $this->addOrganizationMember($userId2);

        $this->organizationMembers()->shouldHaveCount(1);
        $this->owners()->shouldHaveCount(1);

        $userId2->equals($userId2)->shouldBeCalled()->willReturn(true);
        $this->isOrganizationMember($userId2)->shouldReturn(true);

        $this->addOwner($userId2);
        $this->shouldHavePublished(OrganizationMemberRemoved::class);
        $this->shouldHavePublished(OwnerAdded::class);

        $this->organizationMembers()->shouldHaveCount(0);
        $this->owners()->shouldHaveCount(2);
    }

    function it_does_not_allow_to_add_existing_owner(UserId $userId)
    {
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->isOwner($userId)->shouldReturn(true);

        $this->shouldThrow(CollectionElementAlreadyAddedException::class)->duringAddOwner($userId);
    }

    function it_allows_removing_an_owner(UserId $userId, UserId $userId2)
    {
        $this->owners()->shouldHaveCount(1);

        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->isOwner($userId)->shouldReturn(true);
        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->addOwner($userId2);
        $this->shouldHavePublished(OwnerAdded::class);

        $this->owners()->shouldHaveCount(2);

        $userId2->equals($userId2)->shouldBeCalled()->willReturn(true);
        $this->removeOwner($userId2);
        $this->shouldHavePublished(OwnerRemoved::class);

        $this->owners()->shouldHaveCount(1);
    }

    function it_does_not_allow_removing_a_missing_owner(UserId $userId2)
    {

        $this->removeOwner($userId2);
    }

    function it_allows_adding_a_new_organization_organizationMember(UserId $userId, UserId $userId2)
    {
        $this->organizationMembers()->shouldHaveCount(0);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->isOwner($userId2)->shouldReturn(false);
        $this->addOrganizationMember($userId2);
        $this->shouldHavePublished(OrganizationMemberAdded::class);

        $this->organizationMembers()->shouldHaveCount(1);
    }

    function it_does_not_allow_to_add_existing_organization_organizationMember(UserId $userId, UserId $userId2)
    {
        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->isOwner($userId2)->shouldReturn(false);
        $this->addOrganizationMember($userId2);
        $this->shouldHavePublished(OrganizationMemberAdded::class);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $userId2->equals($userId2)->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(CollectionElementAlreadyAddedException::class)->duringAddMember($userId2);
    }

    function it_does_not_allow_to_add_organization_member_when_already_is_an_owner(UserId $userId)
    {
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->isOwner($userId)->shouldReturn(true);
        $userId->id()->shouldBeCalled()->willReturn('user-id');

        $this->shouldThrow(OrganizationMemberIsAlreadyAnOwnerException::class)->duringAddMember($userId);
    }

    function it_allows_removing_a_organization_organizationMember(UserId $userId, UserId $userId2)
    {
        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->isOwner($userId2)->shouldReturn(false);
        $this->addOrganizationMember($userId2);
        $this->shouldHavePublished(OrganizationMemberAdded::class);

        $userId2->equals($userId2)->shouldBeCalled()->willReturn(true);
        $this->removeOrganizationMember($userId2);
        $this->shouldHavePublished(OrganizationMemberRemoved::class);
    }

    function it_does_not_allow_removing_a_missing_organization_organizationMember()
    {
    }

    function it_does_not_remove_owner_because_all_the_organizations_need_one_owner_at_least(UserId $userId)
    {
        $this->shouldThrow(UnauthorizedRemoveOwnerException::class)->duringRemoveOwner($userId);
    }

    function it_checks_if_it_is_owner(UserId $userId, UserId $userId2)
    {
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->isOwner($userId)->shouldReturn(true);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->isOwner($userId2)->shouldReturn(false);
    }

    function it_checks_if_it_is_organization_organizationMember(UserId $userId, UserId $userId2, UserId $userId3)
    {
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->isOrganizationMember($userId)->shouldReturn(true);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->isOrganizationMember($userId2)->shouldReturn(false);

        $this->addOrganizationMember($userId2);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $userId2->equals($userId2)->shouldBeCalled()->willReturn(true);
        $this->isOrganizationMember($userId2)->shouldReturn(true);

        $userId3->equals($userId)->shouldBeCalled()->willReturn(false);
        $userId3->equals($userId2)->shouldBeCalled()->willReturn(false);
        $this->isOrganizationMember($userId3)->shouldReturn(false);
    }

    function it_gets_organization_organizationMember(UserId $userId, UserId $userId2)
    {
        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->isOrganizationMember($userId2)->shouldReturn(false);
        $this->addOrganizationMember($userId2);

        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $userId2->equals($userId2)->shouldBeCalled()->willReturn(true);
        $this->organizationMember($userId2)->shouldReturnAnInstanceOf(Member::class);
    }

    function it_gets_organization_member_because_owner_is_a_kind_od_organization_organizationMember(UserId $userId)
    {
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->organizationMember($userId)->shouldReturnAnInstanceOf(Member::class);
    }

    function it_does_not_gets_organization_organizationMember(UserId $userId, UserId $userId2)
    {
        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->organizationMember($userId2)->shouldReturn(null);
    }

    function it_gets_owner(UserId $userId)
    {
        $userId->equals($userId)->shouldBeCalled()->willReturn(true);
        $this->owner($userId)->shouldReturnAnInstanceOf(Owner::class);
    }

    function it_does_not_gets_owner(UserId $userId, UserId $userId2)
    {
        $userId2->equals($userId)->shouldBeCalled()->willReturn(false);
        $this->owner($userId2)->shouldReturn(null);
    }
}

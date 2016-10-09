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
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationCreated;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipant;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use PhpSpec\ObjectBehavior;

class OrganizationSpec extends ObjectBehavior
{
    function let(OrganizationId $id, OrganizationName $name, Slug $slug, Owner $owner)
    {
        $id->id()->willReturn('organization-id');
        $this->beConstructedWith($id, $name, $slug, $owner);
    }

    function it_can_be_created(Owner $owner, OrganizationName $name, Slug $slug)
    {
        $this->shouldHaveType(Organization::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->id()->shouldReturnAnInstanceOf(OrganizationId::class);
        $this->__toString()->shouldReturn('organization-id');
        $this->name()->shouldReturn($name);
        $this->slug()->shouldReturn($slug);
        $this->shouldHavePublished(OrganizationCreated::class);
        $this->owners()->shouldReturnCollection([$owner]);
    }

    function it_allows_adding_a_new_owner(Owner $owner, Owner $owner2)
    {
        $this->addOwner($owner2);
        $this->owners()->shouldReturnCollection([$owner, $owner2]);
    }

    function it_does_not_allow_to_add_existing_owner(Owner $owner)
    {
        $this->shouldThrow(CollectionElementAlreadyAddedException::class)->during('addOwner', [$owner]);
    }

    function it_allows_removing_an_owner(Owner $owner, Owner $owner2)
    {
        $this->addOwner($owner2);
        $this->removeOwner($owner2);

        $this->owners()->shouldReturnCollection([$owner]);
    }

    function it_does_not_allow_removing_unexistent_owner(Owner $owner2)
    {
        $this->shouldThrow(CollectionElementAlreadyRemovedException::class)->during('removeOwner', [$owner2]);
    }

    function it_allows_adding_a_new_participant(OrganizationParticipant $participant)
    {
        $this->addParticipant($participant);
        $this->participants()->shouldReturnCollection([$participant]);
    }

    function it_does_not_allow_to_add_existing_participant(OrganizationParticipant $participant)
    {
        $this->addParticipant($participant);

        $this->shouldThrow(CollectionElementAlreadyAddedException::class)->during('addParticipant', [$participant]);
    }

    function it_allows_removing_a_participant(OrganizationParticipant $participant)
    {
        $this->addParticipant($participant);
        $this->removeParticipant($participant);
    }

    function it_does_not_allow_removing_unexistent_participant(OrganizationParticipant $participant)
    {
        $this->shouldThrow(CollectionElementAlreadyRemovedException::class)->during('removeParticipant', [$participant]);
    }
}

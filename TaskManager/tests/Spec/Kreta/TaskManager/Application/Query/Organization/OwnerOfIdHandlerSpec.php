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

namespace Spec\Kreta\TaskManager\Application\Query\Organization;

use Kreta\TaskManager\Application\DataTransformer\Organization\MemberDataTransformer;
use Kreta\TaskManager\Application\Query\Organization\OwnerOfIdHandler;
use Kreta\TaskManager\Application\Query\Organization\OwnerOfIdQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerDoesNotExistException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class OwnerOfIdHandlerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $repository, MemberDataTransformer $dataTransformer)
    {
        $this->beConstructedWith($repository, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerOfIdHandler::class);
    }

    function it_serializes_owner(
        OwnerOfIdQuery $query,
        OrganizationRepository $repository,
        Organization $organization,
        MemberDataTransformer $dataTransformer,
        Owner $owner
    ) {
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(
            OrganizationId::generate('organization-id')
        )->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOwner(
            UserId::generate('user-id')
        )->shouldBeCalled()->willReturn(true);
        $organization->owner(UserId::generate('user-id'))
            ->shouldBeCalled()->willReturn($owner);

        $dataTransformer->write($owner)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query);
    }

    function it_does_not_serialize_owner_because_the_organization_does_not_exist(
        OwnerOfIdQuery $query,
        OrganizationRepository $repository
    ) {
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(
            OrganizationId::generate('organization-id')
        )->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OrganizationDoesNotExistException::class)->during__invoke($query);
    }

    function it_does_not_serialize_owner_because_it_does_not_exist(
        OwnerOfIdQuery $query,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $repository->organizationOfId(
            OrganizationId::generate('organization-id')
        )->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOwner(
            UserId::generate('user-id')
        )->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(OwnerDoesNotExistException::class)->during__invoke($query);
    }
}

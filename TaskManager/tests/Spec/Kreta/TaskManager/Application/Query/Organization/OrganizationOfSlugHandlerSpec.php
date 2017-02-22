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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\DataTransformer\Organization\OrganizationDataTransformer;
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfSlugHandler;
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfSlugQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrganizationOfSlugHandlerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $repository, OrganizationDataTransformer $dataTransformer)
    {
        $this->beConstructedWith($repository, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationOfSlugHandler::class);
    }

    function it_serializes_organization(
        OrganizationOfSlugQuery $query,
        OrganizationRepository $repository,
        Organization $organization,
        OrganizationDataTransformer $dataTransformer
    ) {
        $query->organizationSlug()->shouldBeCalled()->willReturn('organization-slug');
        $repository->organizationOfSlug(Argument::type(Slug::class))->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $dataTransformer->write($organization)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query);
    }

    function it_does_not_serialize_organization_because_the_organization_does_not_exist(
        OrganizationOfSlugQuery $query,
        OrganizationRepository $repository
    ) {
        $query->organizationSlug()->shouldBeCalled()->willReturn('organization-slug');
        $repository->organizationOfSlug(Argument::type(Slug::class))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OrganizationDoesNotExistException::class)->during__invoke($query);
    }

    function it_does_not_serialize_organization_when_the_user_does_not_allow_to_perform_this_action(
        OrganizationOfSlugQuery $query,
        OrganizationRepository $repository,
        Organization $organization
    ) {
        $query->organizationSlug()->shouldBeCalled()->willReturn('organization-slug');
        $repository->organizationOfSlug(Argument::type(Slug::class))->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedOrganizationActionException::class)->during__invoke($query);
    }
}

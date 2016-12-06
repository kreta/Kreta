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

namespace Spec\Kreta\TaskManager\Application\Query\Project;

use Kreta\TaskManager\Application\Query\Project\CountProjectsHandler;
use Kreta\TaskManager\Application\Query\Project\CountProjectsQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountProjectsHandlerSpec extends ObjectBehavior
{
    function let(
        OrganizationRepository $organizationRepository,
        OrganizationSpecificationFactory $organizationSpecificationFactory,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory
    ) {
        $this->beConstructedWith(
            $organizationRepository,
            $organizationSpecificationFactory,
            $repository,
            $specificationFactory
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CountProjectsHandler::class);
    }

    function it_counts_projects(
        CountProjectsQuery $query,
        ProjectRepository $repository,
        OrganizationRepository $organizationRepository,
        Organization $organization
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $organizationRepository->organizationOfId(OrganizationId::generate('organization-id'))
            ->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->name()->shouldBeCalled()->willReturn('organization name');
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(2);
        $this->__invoke($query)->shouldReturn(2);
    }

    function it_counts_without_project_name(
        CountProjectsQuery $query,
        ProjectRepository $repository,
        OrganizationRepository $organizationRepository,
        Organization $organization
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $organizationRepository->organizationOfId(OrganizationId::generate('organization-id'))
            ->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->name()->shouldBeCalled()->willReturn(null);
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(3);
        $this->__invoke($query)->shouldReturn(3);
    }

    function it_counts_without_organization_id(
        CountProjectsQuery $query,
        ProjectRepository $repository,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->organizationId()->shouldBeCalled()->willReturn(null);
        $organizationRepository->organizationOfId(Argument::type(OrganizationId::class))
            ->shouldBeCalled()->willReturn(null);
        $organizationRepository->query(Argument::any())->shouldBeCalled()->willReturn([$organization]);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $query->name()->shouldBeCalled()->willReturn('organization name');
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(3);
        $this->__invoke($query)->shouldReturn(3);
    }

    function it_does_not_count_when_user_does_not_allow_to_perform_this_action(
        CountProjectsQuery $query,
        OrganizationRepository $organizationRepository,
        Organization $organization
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $organizationRepository->organizationOfId(OrganizationId::generate('organization-id'))
            ->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedOrganizationActionException::class)->during__invoke($query);
    }
}

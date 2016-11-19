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

use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDataTransformer;
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdHandler;
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class ProjectOfIdHandlerSpec extends ObjectBehavior
{
    function let(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        ProjectDataTransformer $dataTransformer
    ) {
        $this->beConstructedWith($organizationRepository, $repository, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectOfIdHandler::class);
    }

    function it_serializes_project(
        ProjectOfIdQuery $query,
        ProjectRepository $repository,
        Project $project,
        OrganizationId $organizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        ProjectDataTransformer $dataTransformer
    ) {
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $repository->projectOfId(
            ProjectId::generate('project-id')
        )->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);

        $dataTransformer->write($project)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query);
    }

    function it_does_not_serialize_project_because_the_project_does_not_exist(
        ProjectOfIdQuery $query,
        ProjectRepository $repository
    ) {
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $repository->projectOfId(
            ProjectId::generate('project-id')
        )->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(ProjectDoesNotExistException::class)->during__invoke($query);
    }

    function it_does_not_serialize_project_when_the_user_does_not_allowed(
        ProjectOfIdQuery $query,
        ProjectRepository $repository,
        Project $project,
        OrganizationId $organizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization
    ) {
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $repository->projectOfId(
            ProjectId::generate('project-id')
        )->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedProjectResourceException::class)->during__invoke($query);
    }
}

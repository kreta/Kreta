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

namespace Spec\Kreta\TaskManager\Application\Query\Project\Task;

use Kreta\TaskManager\Application\Query\Project\Task\CountTasksHandler;
use Kreta\TaskManager\Application\Query\Project\Task\CountTasksQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountTasksHandlerSpec extends ObjectBehavior
{
    function let(
        ProjectRepository $projectRepository,
        ProjectSpecificationFactory $projectSpecificationFactory,
        OrganizationRepository $organizationRepository,
        TaskRepository $repository,
        TaskSpecificationFactory $specificationFactory
    ) {
        $this->beConstructedWith(
            $projectRepository,
            $projectSpecificationFactory,
            $organizationRepository,
            $repository,
            $specificationFactory
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CountTasksHandler::class);
    }

    function it_counts_tasks(
        CountTasksQuery $query,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        TaskRepository $repository,
        Organization $organization,
        Project $project,
        OrganizationId $organizationId
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))
            ->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task title');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(2);
        $this->__invoke($query)->shouldReturn(2);
    }

    function it_counts_without_task_title(
        CountTasksQuery $query,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        TaskRepository $repository,
        Organization $organization,
        Project $project,
        OrganizationId $organizationId
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))
            ->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled();
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(3);
        $this->__invoke($query)->shouldReturn(3);
    }

    function it_counts_without_project_id(
        CountTasksQuery $query,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        TaskRepository $repository,
        Organization $organization,
        Project $project,
        OrganizationId $organizationId
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled();
        $projectRepository->projectOfId(Argument::type(ProjectId::class))
            ->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task title');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(3);
        $this->__invoke($query)->shouldReturn(3);
    }

    function it_does_not_count_when_user_does_not_allow_to_perform_this_action(
        CountTasksQuery $query,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Project $project,
        OrganizationId $organizationId
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(Argument::type(ProjectId::class))
            ->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedProjectResourceException::class)->during__invoke($query);
    }
}

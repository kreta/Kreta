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

use Kreta\TaskManager\Application\DataTransformer\Project\Task\TaskDataTransformer;
use Kreta\TaskManager\Application\Query\Project\Task\FilterTasksHandler;
use Kreta\TaskManager\Application\Query\Project\Task\FilterTasksQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterTasksHandlerSpec extends ObjectBehavior
{
    function let(
        OrganizationRepository $organizationRepository,
        OrganizationSpecificationFactory $organizationSpecificationFactory,
        ProjectRepository $projectRepository,
        ProjectSpecificationFactory $projectSpecificationFactory,
        TaskRepository $repository,
        TaskSpecificationFactory $specificationFactory,
        TaskDataTransformer $dataTransformer
    ) {
        $this->beConstructedWith(
            $organizationRepository,
            $organizationSpecificationFactory,
            $projectRepository,
            $projectSpecificationFactory,
            $repository,
            $specificationFactory,
            $dataTransformer
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilterTasksHandler::class);
    }

    function it_serializes_filtered_tasks(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        Project $parentProject,
        ProjectId $projectId,
        OrganizationId $organizationId,
        OrganizationId $parentOrganizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Organization $parentOrganization,
        TaskRepository $repository,
        Task $task,
        Task $parent,
        TaskId $parentId,
        TaskDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task-title');
        $query->parentId()->shouldBeCalled()->willReturn('parent-id');

        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $parent->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)
            ->shouldBeCalled()->willReturn($parentProject);
        $parentProject->organizationId()->shouldBeCalled()->willReturn($parentOrganizationId);
        $organizationRepository->organizationOfId($parentOrganizationId)
            ->shouldBeCalled()->willReturn($parentOrganization);
        $parentOrganization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $parent->id()->shouldBeCalled()->willReturn($parentId);

        $query->priority()->shouldBeCalled()->willReturn('low');
        $query->progress()->shouldBeCalled()->willReturn('doing');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);

        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }

    function it_does_not_serialize_filtered_tasks_when_the_user_does_not_allowed(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationId $organizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(UnauthorizedTaskResourceException::class)->during__invoke($query);
    }

    function it_does_not_serialize_filtered_tasks_when_the_user_does_not_allowed_to_access_parent_task(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        Project $parentProject,
        ProjectId $projectId,
        OrganizationId $organizationId,
        OrganizationId $parentOrganizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Organization $parentOrganization,
        TaskRepository $repository,
        Task $parent
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task-title');
        $query->parentId()->shouldBeCalled()->willReturn('parent-id');

        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $parent->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)
            ->shouldBeCalled()->willReturn($parentProject);
        $parentProject->organizationId()->shouldBeCalled()->willReturn($parentOrganizationId);
        $organizationRepository->organizationOfId($parentOrganizationId)
            ->shouldBeCalled()->willReturn($parentOrganization);
        $parentOrganization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(UnauthorizedTaskResourceException::class)->during__invoke($query);
    }

    function it_serializes_filtered_projects_without_parent_id(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationId $organizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        TaskRepository $repository,
        Task $task,
        TaskDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task-title');
        $query->parentId()->shouldBeCalled()->willReturn(null);

        $query->priority()->shouldBeCalled()->willReturn('low');
        $query->progress()->shouldBeCalled()->willReturn('doing');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);

        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }

    function it_serializes_filtered_tasks_with_does_not_exist_task_parent(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationId $organizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        TaskRepository $repository,
        Task $task,
        TaskDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task-title');
        $query->parentId()->shouldBeCalled()->willReturn('parent-id');

        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn(null);

        $query->priority()->shouldBeCalled()->willReturn('low');
        $query->progress()->shouldBeCalled()->willReturn('doing');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);

        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }

    function it_serializes_filtered_projects_without_project_id(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        Project $parentProject,
        ProjectId $projectId,
        ProjectId $parentProjectId,
        OrganizationId $organizationId,
        OrganizationId $parentOrganizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Organization $parentOrganization,
        TaskRepository $repository,
        Task $task,
        Task $parent,
        TaskId $parentId,
        TaskDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn(null);
        $projectRepository->projectOfId(Argument::type(ProjectId::class))->shouldBeCalled()->willReturn(null);

        $organizationRepository->query(Argument::any())->shouldBeCalled()->willReturn([$organization]);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $projectRepository->query(Argument::any())->shouldBeCalled()->willReturn([$project]);
        $project->id()->shouldBeCalled()->willReturn($projectId);
        $query->title()->shouldBeCalled()->willReturn('task-title');
        $query->parentId()->shouldBeCalled()->willReturn('parent-id');

        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $parent->projectId()->shouldBeCalled()->willReturn($parentProjectId);
        $projectRepository->projectOfId($parentProjectId)
            ->shouldBeCalled()->willReturn($parentProject);
        $parentProject->organizationId()->shouldBeCalled()->willReturn($parentOrganizationId);
        $organizationRepository->organizationOfId($parentOrganizationId)
            ->shouldBeCalled()->willReturn($parentOrganization);
        $parentOrganization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $parent->id()->shouldBeCalled()->willReturn($parentId);

        $query->priority()->shouldBeCalled()->willReturn('low');
        $query->progress()->shouldBeCalled()->willReturn('doing');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);

        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }

    function it_serializes_filtered_projects_without_title(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        Project $parentProject,
        ProjectId $projectId,
        OrganizationId $organizationId,
        OrganizationId $parentOrganizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Organization $parentOrganization,
        TaskRepository $repository,
        Task $task,
        Task $parent,
        TaskId $parentId,
        TaskDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled();
        $query->parentId()->shouldBeCalled()->willReturn('parent-id');

        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $parent->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)
            ->shouldBeCalled()->willReturn($parentProject);
        $parentProject->organizationId()->shouldBeCalled()->willReturn($parentOrganizationId);
        $organizationRepository->organizationOfId($parentOrganizationId)
            ->shouldBeCalled()->willReturn($parentOrganization);
        $parentOrganization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $parent->id()->shouldBeCalled()->willReturn($parentId);

        $query->priority()->shouldBeCalled()->willReturn('low');
        $query->progress()->shouldBeCalled()->willReturn('doing');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);

        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }

    function it_serializes_filtered_projects_without_priority(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        Project $parentProject,
        ProjectId $projectId,
        OrganizationId $organizationId,
        OrganizationId $parentOrganizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Organization $parentOrganization,
        TaskRepository $repository,
        Task $task,
        Task $parent,
        TaskId $parentId,
        TaskDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task-title');
        $query->parentId()->shouldBeCalled()->willReturn('parent-id');

        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $parent->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)
            ->shouldBeCalled()->willReturn($parentProject);
        $parentProject->organizationId()->shouldBeCalled()->willReturn($parentOrganizationId);
        $organizationRepository->organizationOfId($parentOrganizationId)
            ->shouldBeCalled()->willReturn($parentOrganization);
        $parentOrganization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $parent->id()->shouldBeCalled()->willReturn($parentId);

        $query->priority()->shouldBeCalled()->willReturn(null);
        $query->progress()->shouldBeCalled()->willReturn('doing');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);

        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }

    function it_serializes_filtered_projects_without_progress(
        FilterTasksQuery $query,
        ProjectRepository $projectRepository,
        Project $project,
        Project $parentProject,
        ProjectId $projectId,
        OrganizationId $organizationId,
        OrganizationId $parentOrganizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Organization $parentOrganization,
        TaskRepository $repository,
        Task $task,
        Task $parent,
        TaskId $parentId,
        TaskDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $query->title()->shouldBeCalled()->willReturn('task-title');
        $query->parentId()->shouldBeCalled()->willReturn('parent-id');

        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $parent->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)
            ->shouldBeCalled()->willReturn($parentProject);
        $parentProject->organizationId()->shouldBeCalled()->willReturn($parentOrganizationId);
        $organizationRepository->organizationOfId($parentOrganizationId)
            ->shouldBeCalled()->willReturn($parentOrganization);
        $parentOrganization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $parent->id()->shouldBeCalled()->willReturn($parentId);

        $query->priority()->shouldBeCalled()->willReturn('low');
        $query->progress()->shouldBeCalled()->willReturn(null);
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$task]);

        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }
}

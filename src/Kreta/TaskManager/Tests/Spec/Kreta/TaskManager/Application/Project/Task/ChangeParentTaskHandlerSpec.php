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

namespace Spec\Kreta\TaskManager\Application\Project\Task;

use Kreta\TaskManager\Application\Project\Task\ChangeParentTaskCommand;
use Kreta\TaskManager\Application\Project\Task\ChangeParentTaskHandler;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskAndTaskParentCannotBeTheSameException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentCannotBelongToOtherProjectException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChangeParentTaskHandlerSpec extends ObjectBehavior
{
    function let(
        TaskRepository $repository,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository
    ) {
        $this->beConstructedWith($repository, $projectRepository, $organizationRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeParentTaskHandler::class);
    }

    function it_changes_a_parent_task(
        ChangeParentTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        TaskId $taskId,
        Task $parent,
        ProjectId $projectId,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        OrganizationId $organizationId,
        TaskId $parentId
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $command->parentId()->shouldBeCalled()->willReturn('parent-id');
        $task->id()->shouldBeCalled()->willReturn($taskId);
        $taskId->equals(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn(false);
        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $parent->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectId->equals($projectId)->shouldBeCalled()->willReturn(true);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $command->changerId()->shouldBeCalled()->willReturn('changer-id');
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isMember(Argument::type(MemberId::class))->shouldBeCalled()->willReturn(true);
        $parent->id()->shouldBeCalled()->willReturn($parentId);
        $task->changeParent($parentId)->shouldBeCalled();
        $repository->persist($task)->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_removes_parent_task(
        ChangeParentTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        ProjectId $projectId,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $command->parentId()->shouldBeCalled()->willReturn(null);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $command->changerId()->shouldBeCalled()->willReturn('changer-id');
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isMember(Argument::type(MemberId::class))->shouldBeCalled()->willReturn(true);
        $task->changeParent(null)->shouldBeCalled();
        $repository->persist($task)->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_change_parent_task_because_task_does_not_exist(
        ChangeParentTaskCommand $command,
        TaskRepository $repository
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(TaskDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_change_parent_task_because_task_and_parent_task_are_the_same(
        ChangeParentTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        TaskId $taskId
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $command->parentId()->shouldBeCalled()->willReturn('task-id');
        $task->id()->shouldBeCalled()->willReturn($taskId);
        $taskId->equals(TaskId::generate('task-id'))->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(TaskAndTaskParentCannotBeTheSameException::class)->during__invoke($command);
    }

    function it_does_not_change_parent_task_because_parent_task_does_not_exist(
        ChangeParentTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        TaskId $taskId
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $command->parentId()->shouldBeCalled()->willReturn('parent-id');
        $task->id()->shouldBeCalled()->willReturn($taskId);
        $taskId->equals(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn(false);
        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(TaskParentDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_change_parent_task_because_task_and_parent_task_projects_are_different(
        ChangeParentTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        TaskId $taskId,
        Task $parent,
        ProjectId $projectId,
        ProjectId $parentProjectId
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $command->parentId()->shouldBeCalled()->willReturn('parent-id');
        $task->id()->shouldBeCalled()->willReturn($taskId);
        $taskId->equals(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn(false);
        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $parent->projectId()->shouldBeCalled()->willReturn($parentProjectId);
        $projectId->equals($parentProjectId)->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(TaskParentCannotBelongToOtherProjectException::class)->during__invoke($command);
    }

    function it_does_not_change_parent_task_because_task_action_is_not_allowed(
        ChangeParentTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        TaskId $taskId,
        Task $parent,
        ProjectId $projectId,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $command->parentId()->shouldBeCalled()->willReturn('parent-id');
        $task->id()->shouldBeCalled()->willReturn($taskId);
        $taskId->equals(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn(false);
        $repository->taskOfId(TaskId::generate('parent-id'))->shouldBeCalled()->willReturn($parent);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $parent->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectId->equals($projectId)->shouldBeCalled()->willReturn(true);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $command->changerId()->shouldBeCalled()->willReturn('changer-id');
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isMember(Argument::type(MemberId::class))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedTaskActionException::class)->during__invoke($command);
    }
}

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

use Kreta\TaskManager\Application\Project\Task\EditTaskCommand;
use Kreta\TaskManager\Application\Project\Task\EditTaskHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EditTaskHandlerSpec extends ObjectBehavior
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
        $this->shouldHaveType(EditTaskHandler::class);
    }

    function it_edits_an_task(
        EditTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        ProjectId $projectId,
        Project $project,
        OrganizationId $organizationId,
        Organization $organization
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $command->editorId()->shouldBeCalled()->willReturn('editor-id');
        $organization->isMember(UserId::generate('editor-id'))->shouldBeCalled()->willReturn(true);
        $command->title()->shouldBeCalled()->willReturn('Task title');
        $command->description()->shouldBeCalled()->willReturn('Task description');
        $task->edit(new TaskTitle('Task title'), 'Task description')->shouldBeCalled();
        $repository->persist(Argument::type(Task::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_edit_task_because_does_not_exist(EditTaskCommand $command, TaskRepository $repository)
    {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(TaskDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_edit_a_task_because_task_edition_is_not_allowed(
        EditTaskCommand $command,
        TaskRepository $repository,
        Task $task,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        ProjectId $projectId,
        Project $project,
        OrganizationId $organizationId,
        Organization $organization
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $command->editorId()->shouldBeCalled()->willReturn('editor-id');
        $organization->isMember(UserId::generate('editor-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedTaskActionException::class)->during__invoke($command);
    }
}

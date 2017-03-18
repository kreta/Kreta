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

declare(strict_types=1);

namespace Spec\Kreta\TaskManager\Application\Command\Project\Task;

use Kreta\TaskManager\Application\Command\Project\Task\ChangeTaskProgressCommand;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChangeTaskProgressHandlerSpec extends ObjectBehavior
{
    private $id;
    private $progress;
    private $editorId;

    function let(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository,
        ChangeTaskProgressCommand $command
    ) {
        $this->beConstructedWith($organizationRepository, $projectRepository, $taskRepository);

        $command->id()->shouldBeCalled()->willReturn('task-id');
        $command->progress()->shouldBeCalled()->willReturn('doing');
        $command->editorId()->shouldBeCalled()->willReturn('editor-id');

        $this->id = TaskId::generate('task-id');
        $this->progress = new TaskProgress('doing');
        $this->editorId = UserId::generate('editor-id');
    }

    function it_does_not_change_task_progress_when_the_task_does_not_exist(
        TaskRepository $taskRepository,
        ChangeTaskProgressCommand $command
    ) {
        $taskRepository->taskOfId($this->id)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(TaskDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_change_task_progress_when_the_editor_is_not_an_organization_member(
        TaskRepository $taskRepository,
        Task $task,
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        Project $project,
        ProjectId $projectId,
        ChangeTaskProgressCommand $command,
        OrganizationId $organizationId,
        Organization $organization
    ) {
        $taskRepository->taskOfId($this->id)->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember(UserId::generate('editor-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedTaskActionException::class)->during__invoke($command);
    }

    function it_changes_task_progress(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository,
        ChangeTaskProgressCommand $command,
        Task $task,
        Project $project,
        ProjectId $projectId,
        OrganizationId $organizationId,
        Organization $organization
    ) {
        $taskRepository->taskOfId($this->id)->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember($this->editorId)->shouldBeCalled()->willReturn(true);
        $task->changeProgress($this->progress)->shouldBeCalled();
        $taskRepository->persist(Argument::type(Task::class))->shouldBeCalled();
        $this->__invoke($command);
    }
}

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

use Kreta\TaskManager\Application\Project\Task\ReassignTaskCommand;
use Kreta\TaskManager\Application\Project\Task\ReassignTaskHandler;
use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
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
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReassignTaskHandlerSpec extends ObjectBehavior
{
    function let(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository
    ) {
        $this->beConstructedWith($organizationRepository, $projectRepository, $taskRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ReassignTaskHandler::class);
    }

    function it_handles_reassigning_task(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository,
        ReassignTaskCommand $command,
        Task $task,
        ProjectId $projectId,
        Project $project,
        OrganizationId $organizationId,
        Organization $organization,
        Member $member,
        MemberId $memberId
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $command->assigneeId()->shouldBeCalled()->willReturn('new-assignee-id');
        $command->editorId()->shouldBeCalled()->willReturn('editor-id');

        $taskRepository->taskOfId(Argument::type(TaskId::class))->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);

        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);

        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isMember(UserId::generate('editor-id'))->shouldBeCalled()->willReturn(true);
        $organization->isMember(UserId::generate('new-assignee-id'))->shouldBeCalled()->willReturn(true);
        $organization->member(UserId::generate('new-assignee-id'))->shouldBeCalled()->willReturn($member);
        $member->id()->shouldBeCalled()->willReturn($memberId);

        $task->reassign(Argument::type(MemberId::class))->shouldBeCalled();
        $taskRepository->persist($task)->shouldBeCalled();

        $this->__invoke($command);
    }

    function it_does_not_allow_to_reassign_when_task_does_not_exist(
        TaskRepository $taskRepository,
        ReassignTaskCommand $command
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');

        $taskRepository->taskOfId(Argument::type(TaskId::class))->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(TaskDoesNotExistException::class)->during('__invoke', [$command]);
    }

    function it_does_not_allow_to_reassign_when_editor_is_not_a_organization_member(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository,
        ReassignTaskCommand $command,
        Task $task,
        ProjectId $projectId,
        Project $project,
        OrganizationId $organizationId,
        Organization $organization
    ) {
        $command->id()->shouldBeCalled()->willReturn('task-id');
        $command->assigneeId()->shouldBeCalled()->willReturn('new-assignee-id');
        $command->editorId()->shouldBeCalled()->willReturn('editor-id');

        $taskRepository->taskOfId(Argument::type(TaskId::class))->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);

        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);

        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->isMember(UserId::generate('editor-id'))->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(UnauthorizedTaskActionException::class)->during__invoke($command);
    }
}

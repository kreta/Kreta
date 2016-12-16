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

namespace Spec\Kreta\TaskManager\Application\DataTransformer\Project\Task;

use Kreta\TaskManager\Application\DataTransformer\Project\Task\TaskDataTransformer;
use Kreta\TaskManager\Application\DataTransformer\Project\Task\TaskDTODataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use PhpSpec\ObjectBehavior;

class TaskDTODataTransformerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $organizationRepository, ProjectRepository $projectRepository)
    {
        $this->beConstructedWith($organizationRepository, $projectRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TaskDTODataTransformer::class);
        $this->shouldImplement(TaskDataTransformer::class);
    }

    function it_transform_task_to_plain_dto(
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        Project $project,
        Organization $organization,
        OrganizationId $organizationId,
        Task $task,
        TaskId $taskId,
        TaskTitle $title,
        ProjectId $projectId,
        TaskPriority $priority,
        TaskProgress $progress,
        MemberId $assigneeId,
        MemberId $creatorId,
        \DateTimeImmutable $createdOn,
        \DateTimeImmutable $updatedOn,
        TaskId $parentId
    ) {
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectId->id()->shouldBeCalled()->willReturn('project-id');

        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->organizationMembers()->shouldBeCalled();
        $organization->owners()->shouldBeCalled();

        $task->id()->shouldBeCalled()->willReturn($taskId);
        $taskId->id()->shouldBeCalled()->willReturn('task-id');
        $task->title()->shouldBeCalled()->willReturn($title);
        $title->title()->shouldBeCalled()->willReturn('The task title');
        $task->priority()->shouldBeCalled()->willReturn($priority);
        $priority->priority()->shouldBeCalled()->willReturn('low');
        $task->progress()->shouldBeCalled()->willReturn($progress);
        $progress->progress()->shouldBeCalled()->willReturn('todo');
        $task->description()->shouldBeCalled()->willReturn('The task description');
        $task->assigneeId()->shouldBeCalled()->willReturn($assigneeId);
        $assigneeId->id()->shouldBeCalled()->willReturn('assignee-id');
        $task->creatorId()->shouldBeCalled()->willReturn($creatorId);
        $creatorId->id()->shouldBeCalled()->willReturn('creator-id');
        $task->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $task->updatedOn()->shouldBeCalled()->willReturn($updatedOn);
        $task->parentId()->shouldBeCalled()->willReturn($parentId);
        $parentId->id()->shouldBeCalled()->willReturn('parent-id');

        $createdOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-20');
        $updatedOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-22');

        $this->write($task);

        $this->read()->shouldReturn([
            'id'          => 'task-id',
            'title'       => 'The task title',
            'priority'    => 'low',
            'progress'    => 'todo',
            'description' => 'The task description',
            'assignee_id' => 'assignee-id',
            'creator_id'  => 'creator-id',
            'created_on'  => '2016-10-20',
            'updated_on'  => '2016-10-22',
            'project_id'  => 'project-id',
            'parent_id'   => 'parent-id',
        ]);
    }

    function it_does_not_transformer_when_task_is_null()
    {
        $this->read()->shouldReturn([]);
    }
}

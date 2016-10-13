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

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskCreated;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use PhpSpec\ObjectBehavior;

class TaskCreatedSpec extends ObjectBehavior
{
    function let(
        TaskId $taskId,
        TaskTitle $title,
        Member $creator,
        Member $assignee,
        TaskPriority $priority,
        ProjectId $projectId,
        TaskId $parentId
    ) {
        $this->beConstructedWith($taskId, $title, 'Description', $creator, $assignee, $priority, $projectId, $parentId);
    }

    function it_creates_a_task_created_event(
        TaskId $taskId,
        TaskTitle $title,
        Member $creator,
        Member $assignee,
        TaskPriority $priority,
        ProjectId $projectId,
        TaskId $parentId
    ) {
        $this->shouldHaveType(TaskCreated::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->title()->shouldReturn($title);
        $this->description()->shouldReturn('Description');
        $this->creator()->shouldReturn($creator);
        $this->assignee()->shouldReturn($assignee);
        $this->priority()->shouldReturn($priority);
        $this->projectId()->shouldReturn($projectId);
        $this->parentId()->shouldReturn($parentId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

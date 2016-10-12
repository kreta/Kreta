<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\Participant;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskCreated;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskCreatedSpec extends ObjectBehavior
{
    function let(
        TaskId $taskId,
        Participant $creator,
        Participant $assignee,
        TaskId $parentId)
    {
        $this->beConstructedWith($taskId, 'Title', 'Description', $creator, $assignee, Task::PRIORITY_LOW, $parentId);
    }

    function it_creates_a_task_created_event(
        TaskId $taskId,
        Participant $creator,
        Participant $assignee,
        TaskId $parentId)
    {
        $this->shouldHaveType(TaskCreated::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->title()->shouldReturn('Title');
        $this->description()->shouldReturn('Description');
        $this->creator()->shouldReturn($creator);
        $this->assignee()->shouldReturn($assignee);
        $this->priority()->shouldReturn(Task::PRIORITY_LOW);
        $this->parentId()->shouldReturn($parentId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

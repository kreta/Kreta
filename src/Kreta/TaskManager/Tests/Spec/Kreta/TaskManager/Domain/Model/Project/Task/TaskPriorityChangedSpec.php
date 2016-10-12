<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriorityChanged;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskPriorityChangedSpec extends ObjectBehavior
{
    function let(TaskId $taskId)
    {
        $this->beConstructedWith($taskId, Task::PRIORITY_LOW);
    }

    function it_creates_task_started_event(TaskId $taskId)
    {
        $this->shouldHaveType(TaskPriorityChanged::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->priority()->shouldReturn(Task::PRIORITY_LOW);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

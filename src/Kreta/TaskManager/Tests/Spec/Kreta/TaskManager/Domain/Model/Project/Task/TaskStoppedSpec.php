<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskStopped;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskStoppedSpec extends ObjectBehavior
{
    function let(TaskId $taskId)
    {
        $this->beConstructedWith($taskId);
    }

    function it_creates_task_stopped_event(TaskId $taskId)
    {
        $this->shouldHaveType(TaskStopped::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

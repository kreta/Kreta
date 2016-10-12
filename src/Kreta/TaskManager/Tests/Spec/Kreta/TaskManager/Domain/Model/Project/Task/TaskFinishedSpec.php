<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskFinished;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskFinishedSpec extends ObjectBehavior
{
    function let(TaskId $taskId)
    {
        $this->beConstructedWith($taskId);
    }

    function it_creates_task_started_event(TaskId $taskId)
    {
        $this->shouldHaveType(TaskFinished::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

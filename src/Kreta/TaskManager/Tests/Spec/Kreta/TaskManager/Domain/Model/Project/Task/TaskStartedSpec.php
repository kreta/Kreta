<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskStarted;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskStartedSpec extends ObjectBehavior
{
    function let(TaskId $taskId)
    {
        $this->beConstructedWith($taskId);
    }
    
    function it_creates_task_started_event(TaskId $taskId)
    {
        $this->shouldHaveType(TaskStarted::class);
        $this->shouldImplement(DomainEvent::class);
        
        $this->id()->shouldReturn($taskId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

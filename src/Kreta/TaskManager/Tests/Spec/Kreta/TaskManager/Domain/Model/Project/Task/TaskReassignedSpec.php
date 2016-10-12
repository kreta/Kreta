<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\Participant;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskReassigned;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskReassignedSpec extends ObjectBehavior
{
    function let(TaskId $taskId, Participant $assignee)
    {
        $this->beConstructedWith($taskId, $assignee);
    }

    function it_creates_task_started_event(TaskId $taskId, Participant $assignee)
    {
        $this->shouldHaveType(TaskReassigned::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->assignee()->shouldReturn($assignee);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskEdited;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskEditedSpec extends ObjectBehavior
{
    function let(TaskId $taskId)
    {
        $this->beConstructedWith($taskId, 'Title', 'Description');
    }

    function it_creates_a_task_edited_event(TaskId $taskId)
    {
        $this->shouldHaveType(TaskEdited::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->title()->shouldReturn('Title');
        $this->description()->shouldReturn('Description');
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

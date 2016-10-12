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

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\TaskManager\Domain\Model\Organization\Participant;
use Kreta\TaskManager\Domain\Model\Project\Task\PriorityNotAllowedException;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskCreated;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskEdited;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskFinished;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriorityChanged;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskReassigned;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskStarted;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskStopped;
use PhpSpec\ObjectBehavior;

class TaskSpec extends ObjectBehavior
{
    function let(TaskId $taskId, Participant $creator, Participant $assignee)
    {
        $taskId->id()->willReturn('task-id');
        $this->beConstructedWith($taskId, 'Title', 'Description', $creator, $assignee, Task::PRIORITY_LOW);
    }

    function it_can_be_created(TaskId $taskId, Participant $creator, Participant $assignee)
    {
        $this->shouldHaveType(Task::class);
        $this->shouldHaveType(AggregateRoot::class);
        
        $this->id()->shouldReturn($taskId);
        $this->title()->shouldReturn('Title');
        $this->description()->shouldReturn('Description');
        $this->creator()->shouldReturn($creator);
        $this->assignee()->shouldReturn($assignee);
        $this->priority()->shouldReturn(Task::PRIORITY_LOW);
        $this->parentId()->shouldReturn(null);

        $this->shouldBeTodo();
        $this->shouldNotBeDoing();
        $this->shouldNotBeDone();

        $this->shouldHavePublished(TaskCreated::class);
        
        $this->__toString()->shouldReturn('task-id');
    }

    function it_can_be_created_as_a_subtask(TaskId $taskId,
                                            Participant $creator,
                                            Participant $assignee,
                                            TaskId $parentId)
    {
        $this->beConstructedWith($taskId, 'Title', 'Description', $creator, $assignee, Task::PRIORITY_LOW, $parentId);
        
        $this->shouldHaveType(Task::class);
        $this->shouldHaveType(AggregateRoot::class);
        
        $this->id()->shouldReturn($taskId);
        $this->title()->shouldReturn('Title');
        $this->description()->shouldReturn('Description');
        $this->creator()->shouldReturn($creator);
        $this->assignee()->shouldReturn($assignee);
        $this->priority()->shouldReturn(Task::PRIORITY_LOW);
        $this->parentId()->shouldReturn($parentId);

        $this->shouldBeTodo();
        $this->shouldNotBeDoing();
        $this->shouldNotBeDone();

        $this->shouldHavePublished(TaskCreated::class);

        $this->__toString()->shouldReturn('task-id');
    }

    function it_cannot_be_created_with_invalid_priority(TaskId $taskId,
                                                        Participant $creator,
                                                        Participant $assignee)
    {
        $this->beConstructedWith($taskId, 'Title', 'Description', $creator, $assignee, 'invalid');
        $this->shouldThrow(PriorityNotAllowedException::class)->duringInstantiation();
    }
    
    function it_can_be_edited()
    {
        $this->edit('New title', 'New description');

        $this->title()->shouldReturn('New title');
        $this->description()->shouldReturn('New description');

        $this->shouldHavePublished(TaskEdited::class);
    }

    function it_can_be_started()
    {
        $this->startDoing();

        $this->shouldNotBeTodo();
        $this->shouldBeDoing();
        $this->shouldNotBeDone();

        $this->shouldHavePublished(TaskStarted::class);
    }

    function it_can_be_stopped()
    {
        $this->stopDoing();

        $this->shouldBeTodo();
        $this->shouldNotBeDoing();
        $this->shouldNotBeDone();

        $this->shouldHavePublished(TaskStopped::class);
    }

    function it_can_be_finished()
    {
        $this->finishDoing();

        $this->shouldNotBeTodo();
        $this->shouldNotBeDoing();
        $this->shouldBeDone();

        $this->shouldHavePublished(TaskFinished::class);
    }

    function it_can_be_reassigned(Participant $assignee)
    {
        $this->reassign($assignee);

        $this->assignee()->shouldReturn($assignee);

        $this->shouldHavePublished(TaskReassigned::class);
    }

    function its_priority_can_be_changed()
    {
        $this->changePriority(Task::PRIORITY_HIGH);

        $this->priority()->shouldReturn(Task::PRIORITY_HIGH);

        $this->shouldHavePublished(TaskPriorityChanged::class);
    }
}

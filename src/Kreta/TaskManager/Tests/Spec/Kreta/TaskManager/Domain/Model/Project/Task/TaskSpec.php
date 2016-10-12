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
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskCreated;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskEdited;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriorityChanged;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgressChanged;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskReassigned;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use PhpSpec\ObjectBehavior;

class TaskSpec extends ObjectBehavior
{
    function let(TaskId $taskId, TaskTitle $title, Participant $creator, Participant $assignee, TaskPriority $priority)
    {
        $taskId->id()->willReturn('task-id');
        $this->beConstructedWith($taskId, $title, 'Description', $creator, $assignee, $priority);
    }

    function it_can_be_created(TaskId $taskId, TaskTitle $title, Participant $creator, Participant $assignee, TaskPriority $priority)
    {
        $this->shouldHaveType(Task::class);
        $this->shouldHaveType(AggregateRoot::class);

        $this->id()->shouldReturn($taskId);
        $this->title()->shouldReturn($title);
        $this->description()->shouldReturn('Description');
        $this->creator()->shouldReturn($creator);
        $this->assignee()->shouldReturn($assignee);
        $this->priority()->shouldReturn($priority);
        $this->parentId()->shouldReturn(null);
        $this->progress()->shouldReturnStatus(TaskProgress::TODO);
        $this->createdOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->updatedOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);

        $this->shouldHavePublished(TaskCreated::class);

        $this->__toString()->shouldReturn('task-id');
    }

    function it_can_be_created_as_a_subtask(TaskId $taskId,
                                            TaskTitle $title,
                                            Participant $creator,
                                            Participant $assignee,
                                            TaskPriority $priority,
                                            TaskId $parentId)
    {
        $this->beConstructedWith($taskId, $title, 'Description', $creator, $assignee, $priority, $parentId);

        $this->shouldHaveType(Task::class);
        $this->shouldHaveType(AggregateRoot::class);

        $this->id()->shouldReturn($taskId);
        $this->title()->shouldReturn($title);
        $this->description()->shouldReturn('Description');
        $this->creator()->shouldReturn($creator);
        $this->assignee()->shouldReturn($assignee);
        $this->priority()->shouldReturn($priority);
        $this->parentId()->shouldReturn($parentId);
        $this->progress()->shouldReturnStatus(TaskProgress::TODO);
        $this->createdOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->updatedOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);

        $this->shouldHavePublished(TaskCreated::class);

        $this->__toString()->shouldReturn('task-id');
    }

    function it_can_be_edited(TaskTitle $title)
    {
        $oldUpdatedOn = $this->updatedOn();

        $this->edit($title, 'New description');

        $this->title()->shouldReturn($title);
        $this->description()->shouldReturn('New description');
        $this->updatedOn()->shouldNotEqual($oldUpdatedOn);

        $this->shouldHavePublished(TaskEdited::class);
    }

    function its_progress_can_be_changed(TaskProgress $progress)
    {
        $oldUpdatedOn = $this->updatedOn();

        $this->changeProgress($progress);

        $this->progress()->shouldReturn($progress);
        $this->updatedOn()->shouldNotEqual($oldUpdatedOn);

        $this->shouldHavePublished(TaskProgressChanged::class);
    }

    function it_can_be_reassigned(Participant $assignee)
    {
        $oldUpdatedOn = $this->updatedOn();

        $this->reassign($assignee);

        $this->assignee()->shouldReturn($assignee);
        $this->updatedOn()->shouldNotEqual($oldUpdatedOn);

        $this->shouldHavePublished(TaskReassigned::class);
    }

    function its_priority_can_be_changed(TaskPriority $priority)
    {
        $oldUpdatedOn = $this->updatedOn();

        $this->changePriority($priority);

        $this->priority()->shouldReturn($priority);
        $this->updatedOn()->shouldNotEqual($oldUpdatedOn);

        $this->shouldHavePublished(TaskPriorityChanged::class);
    }

    public function getMatchers()
    {
        return [
            'returnStatus' => function ($subject, $key) {
                return $subject->progress() === $key;
            },
        ];
    }
}

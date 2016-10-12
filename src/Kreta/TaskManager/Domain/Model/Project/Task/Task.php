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

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\TaskManager\Domain\Model\Organization\Participant;

class Task extends AggregateRoot
{
    private $id;
    private $title;
    private $description;
    private $creator;
    private $assignee;
    private $priority;
    private $progress;
    private $parentId;
    private $createdOn;
    private $updatedOn;

    public function __construct(TaskId $id,
                                TaskTitle $title,
                                string $description,
                                Participant $creator,
                                Participant $assignee,
                                TaskPriority $priority,
                                TaskId $parentId = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->creator = $creator;
        $this->assignee = $assignee;
        $this->priority = $priority;
        $this->progress = TaskProgress::todo();
        $this->parentId = $parentId;

        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskCreated($id, $title, $description, $creator, $assignee, $priority, $parentId)
        );
    }

    public function edit(TaskTitle $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskEdited($this->id, $title, $description)
        );
    }

    public function reassign(Participant $newAssignee)
    {
        $this->assignee = $newAssignee;
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskReassigned($this->id, $newAssignee)
        );
    }

    public function changePriority(TaskPriority $priority)
    {
        $this->priority = $priority;
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskPriorityChanged($this->id, $priority)
        );
    }

    public function changeProgress(TaskProgress $progress)
    {
        $this->progress = $progress;
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskProgressChanged($this->id, $progress)
        );
    }

    public function id() : TaskId
    {
        return $this->id;
    }

    public function title() : TaskTitle
    {
        return $this->title;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function creator() : Participant
    {
        return $this->creator;
    }

    public function assignee() : Participant
    {
        return $this->assignee;
    }

    public function priority() : TaskPriority
    {
        return $this->priority;
    }

    public function progress() : TaskProgress
    {
        return $this->progress;
    }

    public function createdOn() : \DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function updatedOn() : \DateTimeImmutable
    {
        return $this->updatedOn;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}

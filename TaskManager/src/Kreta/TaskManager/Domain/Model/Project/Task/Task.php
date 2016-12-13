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
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;

class Task extends AggregateRoot
{
    private $id;
    private $title;
    private $description;
    private $creatorId;
    private $assigneeId;
    private $priority;
    private $progress;
    private $projectId;
    private $parentId;
    private $createdOn;
    private $updatedOn;

    public function __construct(
        TaskId $id,
        TaskTitle $title,
        string $description,
        MemberId $creatorId,
        MemberId $assigneeId,
        TaskPriority $priority,
        ProjectId $projectId,
        TaskId $parentId = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->creatorId = $creatorId;
        $this->assigneeId = $assigneeId;
        $this->priority = $priority;
        $this->progress = TaskProgress::todo();
        $this->projectId = $projectId;
        $this->parentId = $parentId;

        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskCreated($id, $title, $description, $creatorId, $assigneeId, $priority, $projectId, $parentId)
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

    public function changeParent(TaskId $parentId = null)
    {
        $this->parentId = $parentId;
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskParentChanged($this->id, $this->parentId)
        );
    }

    public function reassign(MemberId $newAssigneeId)
    {
        $this->assigneeId = $newAssigneeId;
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new TaskReassigned($this->id, $newAssigneeId)
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

    public function creatorId() : MemberId
    {
        return $this->creatorId;
    }

    public function assigneeId() : MemberId
    {
        return $this->assigneeId;
    }

    public function priority() : TaskPriority
    {
        return $this->priority;
    }

    public function progress() : TaskProgress
    {
        return $this->progress;
    }

    public function createdOn() : \DateTimeInterface
    {
        return $this->createdOn;
    }

    public function updatedOn() : \DateTimeInterface
    {
        return $this->updatedOn;
    }

    public function projectId() : ProjectId
    {
        return $this->projectId;
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

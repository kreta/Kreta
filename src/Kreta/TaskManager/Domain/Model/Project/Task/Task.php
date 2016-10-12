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

declare(strict_types = 1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\TaskManager\Domain\Model\Organization\Participant;

class Task extends AggregateRoot
{
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    const PROGRESS_TODO = 'todo';
    const PROGRESS_DOING = 'doing';
    const PROGRESS_DONE = 'done';

    private $id;
    private $title;
    private $description;
    private $creator;
    private $assignee;
    private $priority;
    private $progress;
    private $parentId;

    public function __construct(TaskId $id,
                                $title,
                                $description,
                                Participant $creator,
                                Participant $assignee,
                                $priority,
                                TaskId $parentId = null)
    {
        if(!$this->isPriorityAllowed($priority)) {
            throw new PriorityNotAllowedException($priority);
        }

        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->creator = $creator;
        $this->assignee = $assignee;
        $this->priority = $priority;
        $this->progress = self::PROGRESS_TODO;
        $this->parentId = $parentId;
        
        $this->publish(
            new TaskCreated($id, $title, $description, $creator, $assignee, $priority, $parentId)
        );
    }

    public function edit($title, $description)
    {
        $this->title = $title;
        $this->description = $description;

        $this->publish(
            new TaskEdited($this->id, $title, $description)
        );
    }

    public function startDoing()
    {
        $this->progress = self::PROGRESS_DOING;
        
        $this->publish(new TaskStarted($this->id));
    }

    public function stopDoing()
    {
        $this->progress = self::PROGRESS_TODO;
        
        $this->publish(new TaskStopped($this->id));
    }

    public function finishDoing()
    {
        $this->progress = self::PROGRESS_DONE;
        
        $this->publish(new TaskFinished($this->id));
    }

    public function reassign(Participant $newAssignee)
    {
        $this->assignee = $newAssignee;

        $this->publish(
            new TaskReassigned($this->id, $newAssignee)
        );
    }

    public function changePriority($priority)
    {
        if(!$this->isPriorityAllowed($priority)) {
            throw new PriorityNotAllowedException($priority);
        }

        $this->priority = $priority;

        $this->publish(
            new TaskPriorityChanged($this->id, $priority)
        );
    }

    public function id() : TaskId
    {
        return $this->id;
    }

    public function title() : string
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

    public function priority() : string
    {
        return $this->priority;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function isTodo() : bool
    {
        return $this->progress === self::PROGRESS_TODO;
    }

    public function isDoing() : bool
    {
        return $this->progress === self::PROGRESS_DOING;
    }

    public function isDone() : bool
    {
        return $this->progress === self::PROGRESS_DONE;
    }

    public function __toString() : string
    {
        return (string)$this->id->id();
    }
    
    private function isPriorityAllowed($priority) : bool
    {
        return in_array($priority, [
            self::PRIORITY_LOW,
            self::PRIORITY_MEDIUM,
            self::PRIORITY_HIGH
        ]);
    }
    
}

<?php

declare(strict_types = 1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\Participant;

class TaskCreated implements DomainEvent
{
    private $id;
    private $title;
    private $description;
    private $creator;
    private $assignee;
    private $priority;
    private $parentId;
    private $occurredOn;
    
    public function __construct(
        TaskId $id,
        $title,
        $description,
        Participant $creator,
        Participant $assignee,
        $priority,
        TaskId $parentId = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->creator = $creator;
        $this->assignee = $assignee;
        $this->priority = $priority;
        $this->parentId = $parentId;
        $this->occurredOn = new \DateTimeImmutable();
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

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

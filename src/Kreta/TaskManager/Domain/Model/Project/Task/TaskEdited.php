<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class TaskEdited implements DomainEvent
{
    private $taskId;
    private $title;
    private $description;
    private $occurredOn;

    public function __construct(TaskId $taskId, $title, $description)
    {
        $this->taskId = $taskId;
        $this->title = $title;
        $this->description = $description;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : TaskId
    {
        return $this->taskId;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

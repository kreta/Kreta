<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class TaskPriorityChanged implements DomainEvent
{
    private $taskId;
    private $priority;
    private $occurredOn;

    public function __construct(TaskId $taskId, string $priority)
    {
        $this->taskId = $taskId;
        $this->priority = $priority;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : TaskId
    {
        return $this->taskId;
    }

    public function priority() : string
    {
        return $this->priority;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

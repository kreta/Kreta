<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class TaskStarted implements DomainEvent
{
    private $taskId;
    private $occurredOn;

    public function __construct(TaskId $taskId)
    {
        $this->taskId = $taskId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : TaskId
    {
        return $this->taskId;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }

}

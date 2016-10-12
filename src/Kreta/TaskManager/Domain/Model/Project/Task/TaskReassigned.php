<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\Participant;

class TaskReassigned implements DomainEvent
{
    private $taskId;
    private $assignee;
    private $occurredOn;

    public function __construct(TaskId $taskId, Participant $assignee)
    {
        $this->taskId = $taskId;
        $this->assignee = $assignee;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : TaskId
    {
        return $this->taskId;
    }

    public function assignee() : Participant
    {
        return $this->assignee;
    }
    
    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

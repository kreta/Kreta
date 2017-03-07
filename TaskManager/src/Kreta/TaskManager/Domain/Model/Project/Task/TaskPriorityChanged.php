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

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class TaskPriorityChanged implements DomainEvent
{
    private $taskId;
    private $numericId;
    private $priority;
    private $occurredOn;

    public function __construct(TaskId $taskId, NumericId $numericId, TaskPriority $priority)
    {
        $this->taskId = $taskId;
        $this->numericId = $numericId;
        $this->priority = $priority;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : TaskId
    {
        return $this->taskId;
    }

    public function numericId() : NumericId
    {
        return $this->numericId;
    }

    public function priority() : TaskPriority
    {
        return $this->priority;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

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

class TaskProgressChanged implements DomainEvent
{
    private $taskId;
    private $numericId;
    private $progress;
    private $occurredOn;

    public function __construct(TaskId $taskId, NumericId $numericId, TaskProgress $progress)
    {
        $this->taskId = $taskId;
        $this->numericId = $numericId;
        $this->progress = $progress;
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

    public function progress() : TaskProgress
    {
        return $this->progress;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

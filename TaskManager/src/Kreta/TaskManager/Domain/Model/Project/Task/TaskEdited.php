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

class TaskEdited implements DomainEvent
{
    private $taskId;
    private $numericId;
    private $title;
    private $description;
    private $occurredOn;

    public function __construct(TaskId $taskId, NumericId $numericId, TaskTitle $title, string $description)
    {
        $this->taskId = $taskId;
        $this->numericId = $numericId;
        $this->title = $title;
        $this->description = $description;
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

    public function title() : TaskTitle
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

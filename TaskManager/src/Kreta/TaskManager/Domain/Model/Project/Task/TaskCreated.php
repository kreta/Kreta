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
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;

class TaskCreated implements DomainEvent
{
    private $id;
    private $numericId;
    private $title;
    private $description;
    private $creatorId;
    private $assigneeId;
    private $priority;
    private $projectId;
    private $parentId;
    private $occurredOn;

    public function __construct(
        TaskId $id,
        NumericId $numericId,
        TaskTitle $title,
        string $description,
        MemberId $creatorId,
        MemberId $assigneeId,
        TaskPriority $priority,
        ProjectId $projectId,
        TaskId $parentId = null
    ) {
        $this->id = $id;
        $this->numericId = $numericId;
        $this->title = $title;
        $this->description = $description;
        $this->creatorId = $creatorId;
        $this->assigneeId = $assigneeId;
        $this->projectId = $projectId;
        $this->priority = $priority;
        $this->parentId = $parentId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : TaskId
    {
        return $this->id;
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

    public function projectId() : ProjectId
    {
        return $this->projectId;
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

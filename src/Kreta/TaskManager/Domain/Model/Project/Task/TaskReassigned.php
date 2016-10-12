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
use Kreta\TaskManager\Domain\Model\Organization\Member;

class TaskReassigned implements DomainEvent
{
    private $taskId;
    private $assignee;
    private $occurredOn;

    public function __construct(TaskId $taskId, Member $assignee)
    {
        $this->taskId = $taskId;
        $this->assignee = $assignee;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : TaskId
    {
        return $this->taskId;
    }

    public function assignee() : Member
    {
        return $this->assignee;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

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

class TaskParentChanged implements DomainEvent
{
    private $id;
    private $numericId;
    private $parentId;
    private $occurredOn;

    public function __construct(TaskId $id, NumericId $numericId, ?TaskId $parentId)
    {
        $this->id = $id;
        $this->numericId = $numericId;
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

    public function parentId() : ?TaskId
    {
        return $this->parentId;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

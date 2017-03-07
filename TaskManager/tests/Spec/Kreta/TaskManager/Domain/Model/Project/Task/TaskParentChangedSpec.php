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

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Project\Task\NumericId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentChanged;
use PhpSpec\ObjectBehavior;

class TaskParentChangedSpec extends ObjectBehavior
{
    function let(TaskId $taskId, NumericId $numericId, TaskId $parentId)
    {
        $this->beConstructedWith($taskId, $numericId, $parentId);
    }

    function it_creates_a_task_parent_changed_event(TaskId $taskId, NumericId $numericId, TaskId $parentId)
    {
        $this->shouldHaveType(TaskParentChanged::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->numericId()->shouldReturn($numericId);
        $this->parentId()->shouldReturn($parentId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    function it_creates_a_task_parent_changed_event_without_parent(TaskId $taskId, NumericId $numericId)
    {
        $this->beConstructedWith($taskId, $numericId, null);
        $this->id()->shouldReturn($taskId);
        $this->numericId()->shouldReturn($numericId);
        $this->parentId()->shouldReturn(null);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

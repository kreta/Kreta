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
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriorityChanged;
use PhpSpec\ObjectBehavior;

class TaskPriorityChangedSpec extends ObjectBehavior
{
    function let(TaskId $taskId, TaskPriority $priority)
    {
        $this->beConstructedWith($taskId, $priority);
    }

    function it_creates_task_started_event(TaskId $taskId, TaskPriority $priority)
    {
        $this->shouldHaveType(TaskPriorityChanged::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->priority()->shouldReturn($priority);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

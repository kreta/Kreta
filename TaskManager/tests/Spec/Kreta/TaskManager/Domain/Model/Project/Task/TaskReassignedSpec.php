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
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskReassigned;
use PhpSpec\ObjectBehavior;

class TaskReassignedSpec extends ObjectBehavior
{
    function let(TaskId $taskId, MemberId $assigneeId)
    {
        $this->beConstructedWith($taskId, $assigneeId);
    }

    function it_creates_task_started_event(TaskId $taskId, MemberId $assigneeId)
    {
        $this->shouldHaveType(TaskReassigned::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->assigneeId()->shouldReturn($assigneeId);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

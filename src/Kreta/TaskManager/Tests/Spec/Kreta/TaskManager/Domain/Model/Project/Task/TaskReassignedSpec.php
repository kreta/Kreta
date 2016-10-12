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

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\Participant;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskReassigned;
use PhpSpec\ObjectBehavior;

class TaskReassignedSpec extends ObjectBehavior
{
    function let(TaskId $taskId, Participant $assignee)
    {
        $this->beConstructedWith($taskId, $assignee);
    }

    function it_creates_task_started_event(TaskId $taskId, Participant $assignee)
    {
        $this->shouldHaveType(TaskReassigned::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->assignee()->shouldReturn($assignee);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

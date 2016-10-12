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
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgressChanged;
use PhpSpec\ObjectBehavior;

class TaskProgressChangedSpec extends ObjectBehavior
{
    function let(TaskId $taskId, TaskProgress $progress)
    {
        $this->beConstructedWith($taskId, $progress);
    }

    function it_creates_task_started_event(TaskId $taskId, TaskProgress $progress)
    {
        $this->shouldHaveType(TaskProgressChanged::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->progress()->shouldReturn($progress);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

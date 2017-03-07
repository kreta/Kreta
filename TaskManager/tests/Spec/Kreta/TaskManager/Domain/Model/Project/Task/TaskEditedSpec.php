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
use Kreta\TaskManager\Domain\Model\Project\Task\TaskEdited;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use PhpSpec\ObjectBehavior;

class TaskEditedSpec extends ObjectBehavior
{
    function let(TaskId $taskId, NumericId $numericId, TaskTitle $title)
    {
        $this->beConstructedWith($taskId, $numericId, $title, 'Description');
    }

    function it_creates_a_task_edited_event(TaskId $taskId, NumericId $numericId, TaskTitle $title)
    {
        $this->shouldHaveType(TaskEdited::class);
        $this->shouldImplement(DomainEvent::class);

        $this->id()->shouldReturn($taskId);
        $this->numericId()->shouldReturn($numericId);
        $this->title()->shouldReturn($title);
        $this->description()->shouldReturn('Description');
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

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

use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use PhpSpec\ObjectBehavior;

class TaskSpec extends ObjectBehavior
{
    function let(TaskId $taskId)
    {
        $taskId->id()->willReturn('task-id');
        $this->beConstructedWith($taskId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Task::class);
    }

    function it_gets_id()
    {
        $this->id()->shouldReturnAnInstanceOf(TaskId::class);
        $this->__toString()->shouldReturn('task-id');
    }
}

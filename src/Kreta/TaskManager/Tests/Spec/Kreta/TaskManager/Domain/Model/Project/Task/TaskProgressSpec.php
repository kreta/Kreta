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

use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use PhpSpec\ObjectBehavior;

class TaskProgressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TaskProgress::class);
    }

    function it_creates_a_todo_task_progress_value()
    {
        $this->beConstructedTodo();
        $this->progress()->shouldReturn(TaskProgress::TODO);
    }

    function it_creates_a_doing_task_progress_value()
    {
        $this->beConstructedDoing();
        $this->progress()->shouldReturn(TaskProgress::DOING);
    }

    function it_creates_a_done_task_progress_value()
    {
        $this->beConstructedDone();
        $this->progress()->shouldReturn(TaskProgress::DONE);
    }
}

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

use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgressNotAllowedException;
use PhpSpec\ObjectBehavior;

class TaskProgressSpec extends ObjectBehavior
{
    function it_does_not_create_progress_with_invalid_progress()
    {
        $this->beConstructedWith('invalid-progress');
        $this->shouldThrow(TaskProgressNotAllowedException::class)->duringInstantiation();
    }

    function it_creates_a_todo_task_progress_value()
    {
        $this->beConstructedTodo();
        $this->progress()->shouldReturn(TaskProgress::TODO);
        $this->__toString()->shouldReturn(TaskProgress::TODO);
    }

    function it_creates_a_doing_task_progress_value()
    {
        $this->beConstructedDoing();
        $this->progress()->shouldReturn(TaskProgress::DOING);
        $this->__toString()->shouldReturn(TaskProgress::DOING);
    }

    function it_creates_a_done_task_progress_value()
    {
        $this->beConstructedDone();
        $this->progress()->shouldReturn(TaskProgress::DONE);
        $this->__toString()->shouldReturn(TaskProgress::DONE);
    }
}

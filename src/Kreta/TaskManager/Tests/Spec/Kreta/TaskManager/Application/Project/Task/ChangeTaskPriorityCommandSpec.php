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

namespace Spec\Kreta\TaskManager\Application\Project\Task;

use Kreta\TaskManager\Application\Project\Task\ChangeTaskPriorityCommand;
use PhpSpec\ObjectBehavior;

class ChangeTaskPriorityCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('task-id', 'low', 'editor-id');
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(ChangeTaskPriorityCommand::class);

        $this->id()->shouldReturn('task-id');
        $this->priority()->shouldReturn('low');
        $this->editorId()->shouldReturn('editor-id');
    }
}

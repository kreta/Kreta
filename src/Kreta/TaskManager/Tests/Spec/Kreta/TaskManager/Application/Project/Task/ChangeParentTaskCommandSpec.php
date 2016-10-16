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

use Kreta\TaskManager\Application\Project\Task\ChangeParentTaskCommand;
use PhpSpec\ObjectBehavior;

class ChangeParentTaskCommandSpec extends ObjectBehavior
{
    function it_can_be_changed_parent_task_with_basic_info()
    {
        $this->beConstructedWith('task-id', 'changer-id');
        $this->shouldHaveType(ChangeParentTaskCommand::class);
        $this->id()->shouldReturn('task-id');
        $this->changerId()->shouldReturn('changer-id');
        $this->parentId()->shouldReturn(null);
    }

    function it_can_be_created_with_basic_info_and_parent()
    {
        $this->beConstructedWith('task-id', 'changer-id', 'parent-id');
        $this->id()->shouldReturn('task-id');
        $this->changerId()->shouldReturn('changer-id');
        $this->parentId()->shouldReturn('parent-id');
    }
}

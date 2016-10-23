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

use Kreta\TaskManager\Application\Project\Task\ReassignTaskCommand;
use PhpSpec\ObjectBehavior;

class ReassignTaskCommandSpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('task-id', 'new-assignee-id', 'editor-id');
        $this->shouldHaveType(ReassignTaskCommand::class);
        $this->id()->shouldReturn('task-id');
        $this->assigneeId()->shouldReturn('new-assignee-id');
        $this->editorId()->shouldReturn('editor-id');
    }
}

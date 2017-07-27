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

namespace Spec\Kreta\TaskManager\Application\Command\Project\Task;

use Kreta\TaskManager\Application\Command\Project\Task\CreateTaskCommand;
use PhpSpec\ObjectBehavior;

class CreateTaskCommandSpec extends ObjectBehavior
{
    function it_can_be_created_with_basic_info()
    {
        $this->beConstructedWith(
            'title',
            'description',
            'reporter-id',
            'assignee-id',
            'priority',
            'project-id'
        );
        $this->shouldHaveType(CreateTaskCommand::class);
        $this->title()->shouldReturn('title');
        $this->description()->shouldReturn('description');
        $this->reporterId()->shouldReturn('reporter-id');
        $this->assigneeId()->shouldReturn('assignee-id');
        $this->projectId()->shouldReturn('project-id');
        $this->parentId()->shouldReturn(null);
        $this->taskId()->shouldNotReturn(null);
    }

    function it_can_be_created_with_basic_info_and_parent()
    {
        $this->beConstructedWith(
            'title',
            'description',
            'reporter-id',
            'assignee-id',
            'priority',
            'project-id',
            'parent-id'
        );
        $this->title()->shouldReturn('title');
        $this->description()->shouldReturn('description');
        $this->reporterId()->shouldReturn('reporter-id');
        $this->assigneeId()->shouldReturn('assignee-id');
        $this->projectId()->shouldReturn('project-id');
        $this->parentId()->shouldReturn('parent-id');
        $this->taskId()->shouldNotReturn(null);
    }

    function it_can_be_created_with_basic_info_and_parent_and_id()
    {
        $this->beConstructedWith(
            'title',
            'description',
            'reporter-id',
            'assignee-id',
            'priority',
            'project-id',
            'parent-id',
            'task-id'
        );
        $this->title()->shouldReturn('title');
        $this->description()->shouldReturn('description');
        $this->reporterId()->shouldReturn('reporter-id');
        $this->assigneeId()->shouldReturn('assignee-id');
        $this->projectId()->shouldReturn('project-id');
        $this->parentId()->shouldReturn('parent-id');
        $this->taskId()->shouldReturn('task-id');
    }
}

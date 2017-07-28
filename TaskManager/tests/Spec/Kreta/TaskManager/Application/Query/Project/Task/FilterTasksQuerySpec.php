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

namespace Spec\Kreta\TaskManager\Application\Query\Project\Task;

use Kreta\TaskManager\Application\Query\Project\Task\FilterTasksQuery;
use PhpSpec\ObjectBehavior;

class FilterTasksQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id', 0, -1);
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
        $this->assigneeId()->shouldReturn(null);
        $this->reporterId()->shouldReturn(null);
    }

    function it_can_be_created_with_title()
    {
        $this->beConstructedWith('user-id', 0, -1, null, null, 'Task title');
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn('Task title');
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
        $this->assigneeId()->shouldReturn(null);
        $this->reporterId()->shouldReturn(null);
    }

    function it_can_be_created_with_priority()
    {
        $this->beConstructedWith('user-id', 0, -1, null, null, null, 'low');
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn('low');
        $this->progress()->shouldReturn(null);
        $this->assigneeId()->shouldReturn(null);
        $this->reporterId()->shouldReturn(null);
    }

    function it_can_be_created_with_progress()
    {
        $this->beConstructedWith('user-id', 0, -1, null, null, null, null, 'todo');
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn('todo');
        $this->assigneeId()->shouldReturn(null);
        $this->reporterId()->shouldReturn(null);
    }

    function it_can_be_created_with_parent_id()
    {
        $this->beConstructedWith('user-id', 0, -1, 'parent-id');
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn('parent-id');
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
        $this->assigneeId()->shouldReturn(null);
        $this->reporterId()->shouldReturn(null);
    }

    function it_can_be_created_with_project_id()
    {
        $this->beConstructedWith('user-id', 0, -1, null, 'project-id');
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->projectId()->shouldReturn('project-id');
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
        $this->assigneeId()->shouldReturn(null);
        $this->reporterId()->shouldReturn(null);
    }

    function it_can_be_created_with_assignee_id()
    {
        $this->beConstructedWith('user-id', 0, -1, null, null, null, null, null, 'assignee-id');
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->projectId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
        $this->assigneeId()->shouldReturn('assignee-id');
        $this->reporterId()->shouldReturn(null);
    }

    function it_can_be_created_with_reporter_id()
    {
        $this->beConstructedWith('user-id', 0, -1, null, null, null, null, null, null, 'reporter-id');
        $this->shouldHaveType(FilterTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->projectId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
        $this->assigneeId()->shouldReturn(null);
        $this->reporterId()->shouldReturn('reporter-id');
    }
}

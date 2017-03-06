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

use Kreta\TaskManager\Application\Query\Project\Task\CountTasksQuery;
use PhpSpec\ObjectBehavior;

class CountTasksQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id');
        $this->shouldHaveType(CountTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
    }

    function it_can_be_created_with_title()
    {
        $this->beConstructedWith('user-id', null, null, 'Task title');
        $this->shouldHaveType(CountTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->title()->shouldReturn('Task title');
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
    }

    function it_can_be_created_with_priority()
    {
        $this->beConstructedWith('user-id', null, null, null, 'low');
        $this->shouldHaveType(CountTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn('low');
        $this->progress()->shouldReturn(null);
    }

    function it_can_be_created_with_progress()
    {
        $this->beConstructedWith('user-id', null, null, null, null, 'todo');
        $this->shouldHaveType(CountTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn('todo');
    }

    function it_can_be_created_with_parent_id()
    {
        $this->beConstructedWith('user-id', 'parent-id');
        $this->shouldHaveType(CountTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn('parent-id');
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
    }

    function it_can_be_created_with_project_id()
    {
        $this->beConstructedWith('user-id', null, 'project-id');
        $this->shouldHaveType(CountTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->title()->shouldReturn(null);
        $this->parentId()->shouldReturn(null);
        $this->projectId()->shouldReturn('project-id');
        $this->priority()->shouldReturn(null);
        $this->progress()->shouldReturn(null);
    }
}

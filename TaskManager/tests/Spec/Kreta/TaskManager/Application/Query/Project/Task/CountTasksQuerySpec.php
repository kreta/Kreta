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

namespace Spec\Kreta\TaskManager\Application\Query\Project\Task;

use Kreta\TaskManager\Application\Query\Project\Task\CountTasksQuery;
use PhpSpec\ObjectBehavior;

class CountTasksQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id', 'project-id', 'task title');
        $this->shouldHaveType(CountTasksQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->projectId()->shouldReturn('project-id');
        $this->title()->shouldReturn('task title');
    }

    function it_can_be_created_without_title()
    {
        $this->beConstructedWith('user-id', 'project-id');
        $this->userId()->shouldReturn('user-id');
        $this->projectId()->shouldReturn('project-id');
        $this->title()->shouldReturn(null);
    }

    function it_can_be_created_without_project_id()
    {
        $this->beConstructedWith('user-id');
        $this->userId()->shouldReturn('user-id');
        $this->projectId()->shouldReturn(null);
        $this->title()->shouldReturn(null);
    }
}

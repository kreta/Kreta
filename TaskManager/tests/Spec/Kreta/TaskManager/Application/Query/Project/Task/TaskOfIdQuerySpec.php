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

use Kreta\TaskManager\Application\Query\Project\Task\TaskOfIdQuery;
use PhpSpec\ObjectBehavior;

class TaskOfIdQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('task-id', 'user-id');
        $this->shouldHaveType(TaskOfIdQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->taskId()->shouldReturn('task-id');
    }
}

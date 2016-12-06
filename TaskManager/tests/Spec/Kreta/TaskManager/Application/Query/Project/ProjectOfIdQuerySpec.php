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

namespace Spec\Kreta\TaskManager\Application\Query\Project;

use Kreta\TaskManager\Application\Query\Project\ProjectOfIdQuery;
use PhpSpec\ObjectBehavior;

class ProjectOfIdQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('project-id', 'user-id');
        $this->shouldHaveType(ProjectOfIdQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->projectId()->shouldReturn('project-id');
    }
}

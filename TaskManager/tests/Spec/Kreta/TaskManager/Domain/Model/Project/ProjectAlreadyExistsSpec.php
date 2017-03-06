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

namespace Spec\Kreta\TaskManager\Domain\Model\Project;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Project\ProjectAlreadyExists;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use PhpSpec\ObjectBehavior;

class ProjectAlreadyExistsSpec extends ObjectBehavior
{
    function let(ProjectId $projectId)
    {
        $projectId->id()->willReturn('project-id');
        $this->beConstructedWith($projectId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectAlreadyExists::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('Project with id "project-id" already exists');
    }
}

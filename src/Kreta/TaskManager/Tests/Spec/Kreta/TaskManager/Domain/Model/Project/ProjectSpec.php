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

namespace Spec\Kreta\TaskManager\Domain\Model\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use PhpSpec\ObjectBehavior;

class ProjectSpec extends ObjectBehavior
{
    function let(ProjectId $projectId, Slug $projectSlug)
    {
        $projectId->id()->willReturn('project-id');
        $this->beConstructedWith($projectId, 'Project name', $projectSlug);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Project::class);
    }

    function it_has_an_id(ProjectId $projectId)
    {
        $this->id()->shouldReturn($projectId);
        $this->__toString()->shouldReturn('project-id');
    }

    function it_has_a_creation_date()
    {
        $this->createdOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_name()
    {
        $this->name()->shouldReturn('Project name');
    }

    function it_has_a_slug(Slug $projectSlug)
    {
        $this->slug()->shouldReturn($projectSlug);
    }
}

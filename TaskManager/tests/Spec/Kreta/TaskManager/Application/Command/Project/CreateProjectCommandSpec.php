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

namespace Spec\Kreta\TaskManager\Application\Command\Project;

use Kreta\TaskManager\Application\Command\Project\CreateProjectCommand;
use PhpSpec\ObjectBehavior;

class CreateProjectCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Project name', 'organization-id', 'reporter-id', 'project-id', 'project-name');
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(CreateProjectCommand::class);

        $this->id()->shouldReturn('project-id');
        $this->name()->shouldReturn('Project name');
        $this->slug()->shouldReturn('project-name');
        $this->organizationId()->shouldReturn('organization-id');
        $this->reporterId()->shouldReturn('reporter-id');
    }

    function it_can_be_created_without_a_id()
    {
        $this->beConstructedWith('Project name', 'organization-id', 'reporter-id', null, 'project-name');

        $this->id()->shouldNotBe(null);
        $this->name()->shouldReturn('Project name');
        $this->slug()->shouldReturn('project-name');
        $this->organizationId()->shouldReturn('organization-id');
        $this->reporterId()->shouldReturn('reporter-id');
    }

    function it_can_be_created_without_a_slug()
    {
        $this->beConstructedWith('Project name', 'organization-id', 'reporter-id', 'project-id');

        $this->id()->shouldReturn('project-id');
        $this->name()->shouldReturn('Project name');
        $this->slug()->shouldReturn(null);
        $this->organizationId()->shouldReturn('organization-id');
        $this->reporterId()->shouldReturn('reporter-id');
    }
}

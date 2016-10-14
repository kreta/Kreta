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

namespace Spec\Kreta\TaskManager\Application\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\Project\CreateProjectCommand;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use PhpSpec\ObjectBehavior;

class CreateProjectCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('project-id', 'Project name', 'organization-id', 'creator-id', 'project-name');
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(CreateProjectCommand::class);

        $this->id()->shouldReturn('project-id');
        $this->name()->shouldReturn('Project name');
        $this->slug()->shouldReturn('project-name');
        $this->organizationId()->shouldReturn('organization-id');
        $this->creatorId()->shouldReturn('creator-id');
    }

    function it_can_be_created_without_a_slug()
    {
        $this->beConstructedWith('project-id', 'Project name', 'organization-id', 'creator-id');

        $this->id()->shouldReturn('project-id');
        $this->name()->shouldReturn('Project name');
        $this->slug()->shouldReturn(null);
        $this->organizationId()->shouldReturn('organization-id');
        $this->creatorId()->shouldReturn('creator-id');
    }
}

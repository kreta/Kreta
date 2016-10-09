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
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectCreated;
use Kreta\TaskManager\Domain\Model\Project\ProjectEdited;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use PhpSpec\ObjectBehavior;

class ProjectSpec extends ObjectBehavior
{
    function let(ProjectId $projectId, ProjectName $projectName, Slug $projectSlug, OrganizationId $organizationId)
    {
        $projectId->id()->willReturn('project-id');
        $this->beConstructedWith($projectId, $projectName, $projectSlug, $organizationId);
    }

    function it_can_be_created(
        ProjectId $projectId,
        ProjectName $projectName,
        Slug $projectSlug,
        OrganizationId $organizationId)
    {
        $this->shouldHaveType(Project::class);

        $this->id()->shouldReturn($projectId);
        $this->createdOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->name()->shouldReturn($projectName);
        $this->slug()->shouldReturn($projectSlug);
        $this->organizationId()->shouldReturn($organizationId);
        $this->__toString()->shouldReturn('project-id');

        $this->shouldHavePublished(ProjectCreated::class);
    }

    function it_can_be_edited(ProjectName $projectName, Slug $projectSlug)
    {
        $this->edit($projectName, $projectSlug);

        $this->name()->shouldReturn($projectName);
        $this->slug()->shouldReturn($projectSlug);

        $this->shouldHavePublished(ProjectEdited::class);
    }
}

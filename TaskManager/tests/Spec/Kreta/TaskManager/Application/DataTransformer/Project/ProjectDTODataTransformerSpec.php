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

namespace Spec\Kreta\TaskManager\Application\DataTransformer\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDataTransformer;
use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDTODataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use PhpSpec\ObjectBehavior;

class ProjectDTODataTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectDTODataTransformer::class);
        $this->shouldImplement(ProjectDataTransformer::class);
    }

    function it_transform_project_to_plain_dto(
        Project $project,
        ProjectId $projectId,
        ProjectName $name,
        Slug $slug,
        OrganizationId $organizationId,
        \DateTimeImmutable $createdOn,
        \DateTimeImmutable $updatedOn
    ) {
        $project->id()->shouldBeCalled()->willReturn($projectId);
        $projectId->id()->shouldBeCalled()->willReturn('project-id');
        $project->name()->shouldBeCalled()->willReturn($name);
        $name->name()->shouldBeCalled()->willReturn('The project name');
        $project->slug()->shouldBeCalled()->willReturn($slug);
        $slug->slug()->shouldBeCalled()->willReturn('the-project-name');
        $project->createdOn()->shouldBeCalled()->willReturn($createdOn);
        $project->updatedOn()->shouldBeCalled()->willReturn($updatedOn);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationId->id()->shouldBeCalled()->willReturn('organization-id');

        $createdOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-20');
        $updatedOn->format('Y-m-d')->shouldBeCalled()->willReturn('2016-10-22');

        $this->write($project);

        $this->read()->shouldReturn([
            'id'              => 'project-id',
            'name'            => 'The project name',
            'slug'            => 'the-project-name',
            'created_on'      => '2016-10-20',
            'updated_on'      => '2016-10-22',
            'organization_id' => 'organization-id',
        ]);
    }

    function it_does_not_transformer_when_project_is_null()
    {
        $this->read()->shouldReturn([]);
    }
}

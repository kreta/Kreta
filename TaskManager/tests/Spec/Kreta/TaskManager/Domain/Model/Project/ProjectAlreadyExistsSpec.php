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
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Project\ProjectAlreadyExists;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use PhpSpec\ObjectBehavior;

class ProjectAlreadyExistsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectAlreadyExists::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_can_be_created_from_id(ProjectId $projectId)
    {
        $projectId->id()->willReturn('project-id');
        $this->beConstructedFromId($projectId);
        $this->getMessage()->shouldReturn('Project with "project-id" id already exists');
    }

    function it_can_be_created_from_slugs(Slug $slug, Slug $organizationSlug)
    {
        $slug->slug()->willReturn('slug');
        $organizationSlug->slug()->willReturn('organization-slug');
        $this->beConstructedFromSlugs($slug, $organizationSlug);
        $this->getMessage()->shouldReturn(
            'Project with "slug" slug and "organization-slug" organization\'s slug already exists'
        );
    }
}

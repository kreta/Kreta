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

namespace Spec\Kreta\TaskManager\Application\Query\Project;

use Kreta\TaskManager\Application\Query\Project\ProjectOfSlugQuery;
use PhpSpec\ObjectBehavior;

class ProjectOfSlugQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('project-slug', 'organization-slug', 'user-id');
        $this->shouldHaveType(ProjectOfSlugQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->slug()->shouldReturn('project-slug');
        $this->organizationSlug()->shouldReturn('organization-slug');
    }
}

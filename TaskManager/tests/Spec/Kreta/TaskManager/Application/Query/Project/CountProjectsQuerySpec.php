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

use Kreta\TaskManager\Application\Query\Project\CountProjectsQuery;
use PhpSpec\ObjectBehavior;

class CountProjectsQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id', 'organization-id', 'project name');
        $this->shouldHaveType(CountProjectsQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->organizationId()->shouldReturn('organization-id');
        $this->name()->shouldReturn('project name');
    }

    function it_can_be_created_without_name()
    {
        $this->beConstructedWith('user-id', 'organization-id');
        $this->userId()->shouldReturn('user-id');
        $this->organizationId()->shouldReturn('organization-id');
        $this->name()->shouldReturn(null);
    }

    function it_can_be_created_without_organization_id()
    {
        $this->beConstructedWith('user-id');
        $this->userId()->shouldReturn('user-id');
        $this->organizationId()->shouldReturn(null);
        $this->name()->shouldReturn(null);
    }
}

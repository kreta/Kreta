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

namespace Spec\Kreta\TaskManager\Application\Query\Organization;

use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsQuery;
use PhpSpec\ObjectBehavior;

class FilterOrganizationsQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id', 0, -1);
        $this->shouldHaveType(FilterOrganizationsQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->name()->shouldReturn(null);
    }

    function it_can_be_created_with_name()
    {
        $this->beConstructedWith('user-id', 0, -1, 'organization name');
        $this->shouldHaveType(FilterOrganizationsQuery::class);
        $this->userId()->shouldReturn('user-id');
        $this->offset()->shouldReturn(0);
        $this->limit()->shouldReturn(-1);
        $this->name()->shouldReturn('organization name');
    }
}

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

use Kreta\TaskManager\Application\Query\Organization\CountOrganizationsQuery;
use PhpSpec\ObjectBehavior;

class CountOrganizationsQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('organization name');
        $this->shouldHaveType(CountOrganizationsQuery::class);
        $this->name()->shouldReturn('organization name');
    }

    function it_can_be_created_without_name()
    {
        $this->beConstructedWith();
        $this->name()->shouldReturn(null);
    }
}

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

use Kreta\TaskManager\Application\Query\Organization\OrganizationOfSlugQuery;
use PhpSpec\ObjectBehavior;

class OrganizationOfSlugQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('organization-slug', 'user-id');
        $this->shouldHaveType(OrganizationOfSlugQuery::class);
        $this->organizationSlug()->shouldReturn('organization-slug');
        $this->userId()->shouldReturn('user-id');
    }
}

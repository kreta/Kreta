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

use Kreta\TaskManager\Application\Query\Organization\OrganizationMemberOfIdQuery;
use PhpSpec\ObjectBehavior;

class OrganizationMemberOfIdQuerySpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('organization-id', 'member-id', 'user-id');
        $this->shouldHaveType(OrganizationMemberOfIdQuery::class);
        $this->organizationId()->shouldReturn('organization-id');
        $this->memberId()->shouldReturn('member-id');
        $this->userId()->shouldReturn('user-id');
    }
}

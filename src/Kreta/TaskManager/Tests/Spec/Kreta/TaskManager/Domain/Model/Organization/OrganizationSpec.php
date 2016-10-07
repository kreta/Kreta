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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSlug;
use PhpSpec\ObjectBehavior;

class OrganizationSpec extends ObjectBehavior
{
    function let(OrganizationId $organizationId, OrganizationName $organizationName, OrganizationSlug $organizationSlug)
    {
        $organizationId->id()->willReturn('organization-id');
        $this->beConstructedWith($organizationId, $organizationName, $organizationSlug);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Organization::class);
    }

    function it_gets_id()
    {
        $this->id()->shouldReturnAnInstanceOf(OrganizationId::class);
        $this->__toString()->shouldReturn('organization-id');
    }

    function it_gets_name(OrganizationName $organizationName)
    {
        $this->name()->shouldReturn($organizationName);
    }

    function it_gets_slug(OrganizationSlug $organizationSlug)
    {
        $this->slug()->shouldReturn($organizationSlug);
    }
}

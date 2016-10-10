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

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationCreated;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use PhpSpec\ObjectBehavior;

class OrganizationCreatedSpec extends ObjectBehavior
{
    function let(OrganizationId $organizationId)
    {
        $this->beConstructedWith($organizationId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationCreated::class);
    }

    function it_implements_domain_event()
    {
        $this->shouldImplement(DomainEvent::class);
    }

    function it_get_occurred_on()
    {
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }

    function it_gets_organization_id(OrganizationId $organizationId)
    {
        $this->organizationId()->shouldReturn($organizationId);
    }
}

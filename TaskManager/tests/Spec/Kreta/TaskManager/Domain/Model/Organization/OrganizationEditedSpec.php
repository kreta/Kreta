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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationEdited;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use PhpSpec\ObjectBehavior;

class OrganizationEditedSpec extends ObjectBehavior
{
    function let(OrganizationId $id, OrganizationName $name, Slug $slug)
    {
        $this->beConstructedWith($id, $name, $slug);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationEdited::class);
        $this->shouldImplement(DomainEvent::class);
    }

    function it_creates_a_organization_edited_event(OrganizationId $id, OrganizationName $name, Slug $slug)
    {
        $this->id()->shouldReturn($id);
        $this->name()->shouldReturn($name);
        $this->slug()->shouldReturn($slug);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}

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

use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantId;
use Kreta\TaskManager\Domain\Model\Organization\Participant;
use Kreta\TaskManager\Tests\Double\Domain\Model\ParticipantStub;
use PhpSpec\ObjectBehavior;

class ParticipantSpec extends ObjectBehavior
{
    function let(OrganizationParticipantId $id)
    {
        $id->id()->willReturn('organization-participant-id');
        $this->beAnInstanceOf(ParticipantStub::class);
        $this->beConstructedWith($id);
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(Participant::class);
        $this->id()->shouldReturnAnInstanceOf(OrganizationParticipantId::class);
        $this->__toString()->shouldReturn('organization-participant-id');
    }
}

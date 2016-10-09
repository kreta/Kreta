<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\ParticipantUsername;
use PhpSpec\ObjectBehavior;

class OrganizationParticipantUsernameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('kretausername');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ParticipantUsername::class);
    }

    function it_extends_username()
    {
        $this->shouldHaveType(ParticipantUsername::class);
    }
}

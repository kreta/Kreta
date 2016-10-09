<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\OwnerUsername;
use Kreta\TaskManager\Domain\Model\Organization\ParticipantUsername;
use PhpSpec\ObjectBehavior;

class OwnerUsernameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('kretausername');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerUsername::class);
    }

    function it_extends_username()
    {
        $this->shouldHaveType(ParticipantUsername::class);
    }
}

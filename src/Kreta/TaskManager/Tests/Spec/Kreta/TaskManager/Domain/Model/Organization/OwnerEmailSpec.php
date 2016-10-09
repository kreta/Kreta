<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\OwnerEmail;
use Kreta\TaskManager\Domain\Model\Organization\ParticipantEmail;
use PhpSpec\ObjectBehavior;

class OwnerEmailSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('bengor@user.com');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerEmail::class);
    }

    function it_extends_email_address()
    {
        $this->shouldHaveType(ParticipantEmail::class);
    }
}

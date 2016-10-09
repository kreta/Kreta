<?php

namespace Spec\Kreta\SharedKernel\Domain\Model\Identity;

use Kreta\SharedKernel\Domain\Model\Identity\Username;
use Kreta\SharedKernel\Domain\Model\Identity\UsernameInvalidException;
use PhpSpec\ObjectBehavior;

class UsernameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('kretausername');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Username::class);
    }

    function it_does_not_allow_empty_username()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(UsernameInvalidException::class)->duringInstantiation();
    }

    function it_returns_username()
    {
        $this->username()->shouldReturn('kretausername');
        $this->__toString()->shouldReturn('kretausername');
    }
}

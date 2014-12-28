<?php

namespace spec\Kreta\Component\VCS\Serializer\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExistingSerializerExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('github', 'push');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Serializer\Registry\ExistingSerializerException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Serializer for "github"\'s "push" event already exists');
    }
}

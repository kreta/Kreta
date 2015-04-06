<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Serializer\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ExistingSerializerExceptionSpec.
 *
 * @package spec\Kreta\Component\VCS\Serializer\Registry
 */
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

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType('\InvalidArgumentException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Serializer for "github"\'s "push" event already exists');
    }
}

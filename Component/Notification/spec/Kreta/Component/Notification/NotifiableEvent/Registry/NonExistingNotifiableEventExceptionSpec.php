<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Notification\NotifiableEvent\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NonExistingNotifiableEventExceptionSpec.
 *
 * @package spec\Kreta\Component\Notification\NotifiableEvent\Registry
 */
class NonExistingNotifiableEventExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testEvent');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\NotifiableEvent\Registry\NonExistingNotifiableEventException');
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType('\InvalidArgumentException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Notifiable event with name "testEvent" does not exist');
    }
}

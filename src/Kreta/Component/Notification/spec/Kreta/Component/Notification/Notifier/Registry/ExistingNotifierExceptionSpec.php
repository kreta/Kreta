<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Notification\Notifier\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ExistingNotifierExceptionSpec.
 *
 * @package spec\Kreta\Component\Notification\Notifier\Registry
 */
class ExistingNotifierExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testNotifier');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Notifier\Registry\ExistingNotifierException');
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType('\InvalidArgumentException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Notifier with name "testNotifier" already exists');
    }
}

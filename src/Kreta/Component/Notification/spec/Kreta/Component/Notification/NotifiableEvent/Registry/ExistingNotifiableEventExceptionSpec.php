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

namespace spec\Kreta\Component\Notification\NotifiableEvent\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ExistingNotifiableEventExceptionSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ExistingNotifiableEventExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testEvent');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\NotifiableEvent\Registry\ExistingNotifiableEventException');
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType('\InvalidArgumentException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Notifiable event with name "testEvent" already exists');
    }
}

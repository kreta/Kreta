<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FormHandlerEventSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\Event
 */
class FormHandlerEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('success', 'Saved successfully');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Event\FormHandlerEvent');
    }

    function its_type_is_mutable()
    {
        $this->setType('error')->shouldReturn($this);
        $this->getType()->shouldReturn('error');
    }

    function its_message_is_mutable()
    {
        $this->setMessage('Error saving')->shouldReturn($this);
        $this->getMessage()->shouldReturn('Error saving');
    }
}

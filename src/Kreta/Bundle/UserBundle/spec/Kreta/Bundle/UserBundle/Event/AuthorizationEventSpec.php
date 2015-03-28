<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\UserBundle\Event;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorizationEventSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\Event
 */
class AuthorizationEventSpec extends ObjectBehavior
{
    function let(Request $request)
    {
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Event\AuthorizationEvent');
    }

    function it_extends_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_gets_request(Request $request)
    {
        $this->getRequest()->shouldReturn($request);
    }
}

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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CookieEventSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\Event
 */
class CookieEventSpec extends ObjectBehavior
{
    function let(SessionInterface $session, Response $response)
    {
        $this->beConstructedWith($session, $response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Event\CookieEvent');
    }

    function it_extends_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_response_is_mutable(Response $response, Response $newResponse)
    {
        $this->getResponse()->shouldReturn($response);
        $this->setResponse($newResponse)->shouldReturn($this);
        $this->getResponse()->shouldReturn($newResponse);
    }
    
    function it_gets_session(SessionInterface $session)
    {
        $this->getSession()->shouldReturn($session);
    }
}

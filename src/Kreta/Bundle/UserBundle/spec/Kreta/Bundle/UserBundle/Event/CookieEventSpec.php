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

namespace spec\Kreta\Bundle\UserBundle\Event;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CookieEventSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

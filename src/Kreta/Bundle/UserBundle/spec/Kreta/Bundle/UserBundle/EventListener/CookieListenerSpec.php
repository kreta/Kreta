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

namespace spec\Kreta\Bundle\UserBundle\EventListener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class CookieListenerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class CookieListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\EventListener\CookieListener');
    }

    function it_listens_cookie_event(
        FilterResponseEvent $event,
        Response $response,
        Request $request,
        ResponseHeaderBag $responseHeaderBag,
        SessionInterface $session
    ) {
        $event->getResponse()->shouldBeCalled()->willReturn($response);
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getSession()->shouldBeCalled()->willReturn($session);
        $session->get('access_token')->shouldBeCalled()->willReturn('accesstoken');
        $responseHeaderBag->setCookie(Argument::type('Symfony\Component\HttpFoundation\Cookie'))->shouldBeCalled();
        $responseHeaderBag->setCookie(Argument::type('Symfony\Component\HttpFoundation\Cookie'))->shouldBeCalled();
        $response->headers = $responseHeaderBag;

        $this->onCookieEvent($event);
    }
}

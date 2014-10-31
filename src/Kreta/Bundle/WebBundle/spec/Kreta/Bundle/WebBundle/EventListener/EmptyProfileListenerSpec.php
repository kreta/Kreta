<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WebBundle\EventListener;

use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class EmptyProfileListenerSpec.
 *
 * @package spec\Kreta\Bundle\WebBundle\EventListener
 */
class EmptyProfileListenerSpec extends ObjectBehavior
{
    function let(SecurityContextInterface $securityContext, Router $router, Session $session)
    {
        $this->beConstructedWith($securityContext, $router, $session);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\EventListener\EmptyProfileListener');
    }

    function it_ignores_subrequests(GetResponseEvent $event)
    {
        $event->getRequestType()->shouldBeCalled()->willReturn(HttpKernel::SUB_REQUEST);
        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }

    function it_avoids_infinite_loops(GetResponseEvent $event, Session $session, FlashBagInterface $flashBag)
    {
        $event->getRequestType()->shouldBeCalled()->willReturn(HttpKernel::MASTER_REQUEST);
        $session->getFlashBag()->shouldBeCalled()->willReturn($flashBag);
        $flashBag->has('error')->shouldBeCalled()->willReturn(true);
        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }

    function it_ignores_if_user_has_email(
        GetResponseEvent $event,
        Session $session,
        FlashBagInterface $flashBag,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $event->getRequestType()->shouldBeCalled()->willReturn(HttpKernel::MASTER_REQUEST);
        $session->getFlashBag()->shouldBeCalled()->willReturn($flashBag);
        $flashBag->has('error')->shouldBeCalled()->willReturn(false);

        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $user->getEmail()->shouldBeCalled()->willReturn('user@kreta.io');

        $event->setResponse(Argument::any())->shouldNotBeCalled();

        $this->onKernelRequest($event);
    }

    function it_redirects_to_profile_if_empty_email(
        GetResponseEvent $event,
        Session $session,
        FlashBagInterface $flashBag,
        SecurityContextInterface $securityContext,
        TokenInterface $token, UserInterface $user,
        Router $router
    )
    {
        $event->getRequestType()->shouldBeCalled()->willReturn(HttpKernel::MASTER_REQUEST);
        $session->getFlashBag()->shouldBeCalled()->willReturn($flashBag);
        $flashBag->has('error')->shouldBeCalled()->willReturn(false);

        $flashBag->add('error', 'Email required to start using Kreta')->shouldBeCalled();
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $user->getEmail()->shouldBeCalled()->willReturn(null);
        $router->generate('kreta_web_user_edit')->shouldBeCalled()->willReturn('/user/edit');

        $event->setResponse(Argument::type('\Symfony\Component\HttpFoundation\RedirectResponse'))->shouldBeCalled();

        $this->onKernelRequest($event);
    }
}

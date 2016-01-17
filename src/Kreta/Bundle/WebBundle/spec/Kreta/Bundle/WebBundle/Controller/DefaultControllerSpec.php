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

namespace spec\Kreta\Bundle\WebBundle\Controller;

use Kreta\Bundle\UserBundle\Event\CookieEvent;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Spec class of default controller.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class DefaultControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\DefaultController');
    }

    function it_extends_symfony_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_renders_landing_if_not_logged_in(
        ContainerInterface $container,
        Request $request,
        TokenStorageInterface $context,
        TokenInterface $token,
        TwigEngine $engine
    )
    {
        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $container->has('templating')->shouldBeCalled()->willReturn(true);
        $container->get('templating')->shouldBeCalled()->willReturn($engine);
        $engine->renderResponse('KretaWebBundle::layout.html.twig');

        $this->indexAction($request);
    }

    function it_renders_dashboard_if_logged_in(
        ContainerInterface $container,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        EventDispatcherInterface $eventDispatcher,
        CookieEvent $event,
        TwigEngine $engine,
        Request $request,
        SessionInterface $session,
        Response $response
    )
    {
        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $request->getSession()->shouldBeCalled()->willReturn($session);
        $container->get('event_dispatcher')->shouldBeCalled()->willReturn($eventDispatcher);
        $eventDispatcher->dispatch(
            'kreta_user_event_cookie', Argument::type('Kreta\Bundle\UserBundle\Event\CookieEvent')
        )->shouldBeCalled()->willReturn($event);

        $container->has('templating')->shouldBeCalled()->willReturn(true);
        $container->get('templating')->shouldBeCalled()->willReturn($engine);
        $event->getResponse()->shouldBeCalled()->willReturn($response);
        $engine->renderResponse('KretaWebBundle:Default:app.html.twig', [], $response);

        $this->indexAction($request);
    }

    function it_renders_dashboard(ContainerInterface $container, TwigEngine $engine, Response $response)
    {
        $container->has('templating')->shouldBeCalled()->willReturn(true);
        $container->get('templating')->shouldBeCalled()->willReturn($engine);
        $engine->renderResponse('KretaWebBundle:Default:app.html.twig', [], $response);

        $this->dashboardAction($response);
    }
}

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\UserBundle\Controller;

use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class RegistrationControllerSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\Controller
 */
class RegistrationControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Controller\RegistrationController');
    }

    function it_extends_fos_user_registration_controller()
    {
        $this->shouldHaveType('FOS\UserBundle\Controller\RegistrationController');
    }

    function it_throws_access_denied_exception_when_confirmed_action(
        ContainerInterface $container,
        SecurityContextInterface $context,
        TokenInterface $token
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($context);
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new AccessDeniedException('This user does not have access to this section.'))
            ->during('confirmedAction');
    }

    function its_confirmed_action(
        ContainerInterface $container,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user,
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        AuthorizationEvent $event,
        RouterInterface $router
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($context);
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('event_dispatcher')->shouldBeCalled()->willReturn($eventDispatcher);
        $eventDispatcher->dispatch(
            'kreta_user_event_authorization', Argument::type('Kreta\Bundle\UserBundle\Event\AuthorizationEvent')
        )->shouldBeCalled()->willReturn($event);

        $container->get('router')->shouldBeCalled()->willReturn($router);
        $router->generate('kreta_web_homepage', [], false)->shouldBeCalled()->willReturn('/');
        
        $this->confirmedAction();
    }
}

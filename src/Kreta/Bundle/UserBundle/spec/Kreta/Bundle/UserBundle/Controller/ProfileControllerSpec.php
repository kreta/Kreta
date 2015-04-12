<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\UserBundle\Controller;

use Kreta\Component\User\Form\Handler\UserHandler;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProfileControllerSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\Controller
 */
class ProfileControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Controller\ProfileController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_profile_action(
        ContainerInterface $container,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($context);
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $this->getProfileAction()->shouldReturn($user);
    }

    function it_posts_profile_action(
        ContainerInterface $container,
        UserHandler $handler,
        Request $request,
        UserInterface $user
    )
    {
        $container->get('kreta_user.form_handler.user')->shouldBeCalled()->willReturn($handler);
        $handler->processForm($request)->shouldBeCalled()->willReturn($user);

        $this->postProfileAction($request)->shouldReturn($user);
    }
}

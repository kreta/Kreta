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

namespace spec\Kreta\Bundle\UserBundle\Controller;

use Kreta\Component\User\Form\Handler\UserHandler;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class ProfileControllerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user
    ) {
        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $this->getProfileAction()->shouldReturn($user);
    }

    function it_posts_profile_action(
        ContainerInterface $container,
        UserHandler $handler,
        Request $request,
        UserInterface $user
    ) {
        $container->get('kreta_user.form_handler.profile')->shouldBeCalled()->willReturn($handler);
        $handler->processForm($request)->shouldBeCalled()->willReturn($user);

        $this->postProfileAction($request)->shouldReturn($user);
    }
}

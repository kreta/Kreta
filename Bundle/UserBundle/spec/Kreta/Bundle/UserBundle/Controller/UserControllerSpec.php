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

use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserControllerSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\Controller
 */
class UserControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Controller\UserController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_users_action(ContainerInterface $container, UserRepository $userRepository, UserInterface $user)
    {
        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn([$user]);

        $this->getUsersAction()->shouldReturn([$user]);
    }
}

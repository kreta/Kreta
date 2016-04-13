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

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserControllerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

    function it_gets_users_action(
        ContainerInterface $container,
        UserRepository $userRepository,
        UserInterface $user,
        ParamFetcher $paramFetcher
    ) {
        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($userRepository);

        $paramFetcher->get('email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $paramFetcher->get('username')->shouldBeCalled()->willReturn('kreta');
        $paramFetcher->get('firstName')->shouldBeCalled()->willReturn('KretaFirst');
        $paramFetcher->get('lastName')->shouldBeCalled()->willReturn('KretaLast');
        $paramFetcher->get('enabled')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('username');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);

        $userRepository->findBy(
            [
                'like' => [
                    'email'     => 'kreta@kreta.com',
                    'username'  => 'kreta',
                    'firstName' => 'KretaFirst',
                    'lastName'  => 'KretaLast',
                    'enabled'   => 1,
                ],
            ],
            ['username' => 'ASC'],
            10,
            1
        )->shouldBeCalled()->willReturn([$user]);

        $this->getUsersAction($paramFetcher)->shouldReturn([$user]);
    }
}

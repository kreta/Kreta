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

use Kreta\Bundle\UserBundle\Mailer\Mailer;
use Kreta\Component\User\Form\Handler\UserHandler;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class InvitationControllerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class InvitationControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Controller\InvitationController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_posts_users_action(
        Request $request,
        ParameterBag $bag,
        ContainerInterface $container,
        UserRepository $repository,
        UserInterface $user,
        UserHandler $handler,
        Mailer $mailer
    )
    {
        $request->request = $bag;
        $bag->get('force')->shouldBeCalled()->willReturn(false);
        $bag->remove('force')->shouldBeCalled();
        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($repository);
        $bag->get('email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $repository->findOneBy(['email' => 'kreta@kreta.com'])->shouldBeCalled()->willReturn($user);

        $container->get('kreta_user.form_handler.invitation')->shouldBeCalled()->willReturn($handler);
        $user->isEnabled()->shouldBeCalled()->willReturn(true);
        $handler->processForm($request, $user)->shouldBeCalled()->willReturn($user);
        $handler->processForm($request)->shouldBeCalled()->willReturn($user);

        $container->get('kreta_user.mailer')->shouldBeCalled()->willReturn($mailer);
        $mailer->sendInvitationEmail($user)->shouldBeCalled();

        $this->postUsersAction($request)->shouldReturn($user);
    }
}

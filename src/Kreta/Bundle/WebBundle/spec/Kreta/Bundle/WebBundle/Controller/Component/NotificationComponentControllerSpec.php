<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WebBundle\Controller\Component;

use Kreta\Component\Notification\Repository\NotificationRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class NotificationComponentControllerSpec.
 *
 * @package spec\Kreta\Bundle\WebBundle\Controller
 */
class NotificationComponentControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\Component\NotificationComponentController');
    }

    function it_renders_icon_count(
        ContainerInterface $container,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        NotificationRepository $notificationRepository,
        TwigEngine $engine
    )
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $container->get('kreta_notification.repository.notification')
            ->shouldBeCalled()->willReturn($notificationRepository);
        $notificationRepository->getUsersUnreadNotificationsCount($user)->shouldBeCalled()->willReturn(5);

        $container->get('templating')->shouldBeCalled()->willReturn($engine);
        $engine->renderResponse('KretaWebBundle:Component/Notification:icon.html.twig', ['count' => 5]);

        $this->iconAction();
    }
}

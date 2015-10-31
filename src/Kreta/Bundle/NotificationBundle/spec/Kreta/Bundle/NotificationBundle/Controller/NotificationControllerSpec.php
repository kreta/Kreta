<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\NotificationBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use Kreta\Component\Notification\Repository\NotificationRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class NotificationControllerSpec.
 *
 * @package spec\Kreta\Bundle\NotificationBundle\Controller
 */
class NotificationControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\Controller\NotificationController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_notifications(
        ContainerInterface $container,
        NotificationRepository $repository,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        ParamFetcher $paramFetcher,
        NotificationInterface $notification
    )
    {
        $container->get('kreta_notification.repository.notification')->shouldBeCalled()->willReturn($repository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $paramFetcher->get('q')->shouldBeCalled()->willReturn('notification-title');
        $paramFetcher->get('project')->shouldBeCalled()->willReturn('project-id');
        $paramFetcher->get('type')->shouldBeCalled()->willReturn('issue_new');
        $paramFetcher->get('read')->shouldBeCalled()->willReturn('true');
        $paramFetcher->get('date')->shouldBeCalled()->willReturn('2014-10-20');
        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('title');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);

        $repository->findByUser(
            $user,
            [
                'title' => 'notification-title',
                'p.id'  => 'project-id',
                'type'  => 'issue_new',
                'read'  => true,
                'date'  => new \DateTime('2014-10-20')
            ],
            ['title' => 'ASC'],
            10,
            1
        )->shouldBeCalled()->willReturn([$notification]);


        $this->getNotificationsAction($paramFetcher)->shouldReturn([$notification]);
    }

    function it_patches_notification(
        ContainerInterface $container,
        NotificationRepository $repository,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        NotificationInterface $notification,
        Handler $handler,
        Request $request
    )
    {
        $container->get('kreta_notification.repository.notification')->shouldBeCalled()->willReturn($repository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $repository->findOneByUser('notification-id', $user)->shouldBeCalled()->willReturn($notification);
        $container->get('kreta_notification.form_handler.notification')->shouldBeCalled()->willReturn($handler);
        $handler->processForm($request, $notification, ['method' => 'PATCH'])
            ->shouldBeCalled()->willReturn($notification);

        $this->patchNotificationsAction($request, 'notification-id')->shouldReturn($notification);
    }
}

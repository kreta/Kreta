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

use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Component\Core\Form\Handler\Interfaces\HandlerInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    function it_throws_not_found_http_exception_when_the_request_is_null(Request $request, ParameterBagInterface $bag)
    {
        $request->query = $bag;
        $bag->get('token')->shouldBeCalled()->willReturn(null);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $bag->get('email')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException())->during('registerAction', [$request]);
    }

    function it_renders_registration_view(
        Request $request,
        ParameterBagInterface $bag,
        ContainerInterface $container,
        UserRepository $repository,
        UserInterface $user,
        HandlerInterface $handler,
        FormInterface $form,
        EngineInterface $engine,
        FormView $formView,
        Response $response
    )
    {
        $request->query = $bag;
        $bag->get('token')->shouldBeCalled()->willReturn(null);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $bag->get('email')->shouldBeCalled()->willReturn('kreta@kreta.com');

        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(['email' => 'kreta@kreta.com'], false)->shouldBeCalled()->willReturn($user);
        $container->get('kreta_user.form_handler.registration')->shouldBeCalled()->willReturn($handler);
        $handler->createForm($user)->shouldBeCalled()->willReturn($form);
        $form->setData($user)->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(false);

        $container->get('templating')->shouldBeCalled()->willReturn($engine);
        $form->createView()->shouldBeCalled()->willReturn($formView);
        $engine->renderResponse(
            'FOSUserBundle:Registration:register.html.twig',
            ['form' => $formView, 'user' => $user],
            null
        )->shouldBeCalled()->willReturn($response);

        $this->registerAction($request)->shouldReturn($response);
    }

    function it_throws_access_denied_exception_because_the_user_is_not_logged(
        Request $request,
        ParameterBagInterface $bag,
        ContainerInterface $container,
        UserRepository $repository,
        UserInterface $user,
        HandlerInterface $handler,
        FormInterface $form,
        EventDispatcherInterface $eventDispatcher,
        FormEvent $event,
        UserManager $userManager,
        TokenStorageInterface $context,
        TokenInterface $token
    )
    {
        $request->query = $bag;
        $bag->get('token')->shouldBeCalled()->willReturn(null);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $bag->get('email')->shouldBeCalled()->willReturn('kreta@kreta.com');

        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(['email' => 'kreta@kreta.com'], false)->shouldBeCalled()->willReturn($user);
        $container->get('kreta_user.form_handler.registration')->shouldBeCalled()->willReturn($handler);
        $handler->createForm($user)->shouldBeCalled()->willReturn($form);
        $form->setData($user)->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);

        $user->setEnabled(true)->shouldBeCalled()->willReturn($user);
        $user->setConfirmationToken(null)->shouldBeCalled()->willReturn($user);

        $container->get('event_dispatcher')->shouldBeCalled()->willReturn($eventDispatcher);
        $eventDispatcher->dispatch(
            FOSUserEvents::REGISTRATION_SUCCESS, Argument::type('FOS\UserBundle\Event\FormEvent')
        )->shouldBeCalled()->willReturn($event);
        $container->get('fos_user.user_manager')->shouldBeCalled()->willReturn($userManager);
        $userManager->updateUser($user)->shouldBeCalled();
        $eventDispatcher->dispatch(
            FOSUserEvents::REGISTRATION_COMPLETED, Argument::type('FOS\UserBundle\Event\FilterUserResponseEvent')
        )->shouldBeCalled()->willReturn($event);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new AccessDeniedException('This user does not have access to this section.'))
            ->during('registerAction', [$request]);
    }

    function it_registers_successfully(
        Request $request,
        ParameterBagInterface $bag,
        ContainerInterface $container,
        UserRepository $repository,
        UserInterface $user,
        HandlerInterface $handler,
        FormInterface $form,
        EventDispatcherInterface $eventDispatcher,
        FormEvent $event,
        UserManager $userManager,
        TokenStorageInterface $context,
        TokenInterface $token,
        RouterInterface $router
    )
    {
        $request->query = $bag;
        $bag->get('token')->shouldBeCalled()->willReturn(null);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $bag->get('email')->shouldBeCalled()->willReturn('kreta@kreta.com');

        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(['email' => 'kreta@kreta.com'], false)->shouldBeCalled()->willReturn($user);
        $container->get('kreta_user.form_handler.registration')->shouldBeCalled()->willReturn($handler);
        $handler->createForm($user)->shouldBeCalled()->willReturn($form);
        $form->setData($user)->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);

        $user->setEnabled(true)->shouldBeCalled()->willReturn($user);
        $user->setConfirmationToken(null)->shouldBeCalled()->willReturn($user);

        $container->get('event_dispatcher')->shouldBeCalled()->willReturn($eventDispatcher);
        $eventDispatcher->dispatch(
            FOSUserEvents::REGISTRATION_SUCCESS, Argument::type('FOS\UserBundle\Event\FormEvent')
        )->shouldBeCalled()->willReturn($event);
        $container->get('fos_user.user_manager')->shouldBeCalled()->willReturn($userManager);
        $userManager->updateUser($user)->shouldBeCalled();
        $eventDispatcher->dispatch(
            FOSUserEvents::REGISTRATION_COMPLETED, Argument::type('FOS\UserBundle\Event\FilterUserResponseEvent')
        )->shouldBeCalled()->willReturn($event);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $eventDispatcher->dispatch(
            AuthorizationEvent::NAME, Argument::type('Kreta\Bundle\UserBundle\Event\AuthorizationEvent')
        )->shouldBeCalled()->willReturn($event);

        $container->get('router')->shouldBeCalled()->willReturn($router);
        $router->generate('kreta_web_homepage', [], false)->shouldBeCalled()->willReturn('http://kreta.io/');

        $this->registerAction($request);
    }
}

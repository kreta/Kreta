<?php

namespace spec\Kreta\Bundle\WebBundle\Controller;

use Kreta\Bundle\WebBundle\FormHandler\UserFormHandler;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;

class UserControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\UserController');
    }

    function it_denies_access_if_user_not_found(Request $request, ContainerInterface $container,
                                                SecurityContext $securityContext)
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn(null);
        $this->shouldThrow('\Symfony\Component\Security\Core\Exception\AccessDeniedException')
            ->duringEditAction($request);
    }

    function it_edits_user(Request $request, ContainerInterface $container, TokenInterface $token,
                           SecurityContext $securityContext, UserInterface $user, UserFormHandler $formHandler,
                           FormInterface $form, FormView $formView)
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $container->get('kreta_web.form_handler.user')->shouldBeCalled()->willReturn($formHandler);
        $formHandler->handleForm($request, $user)->shouldBeCalled()->willReturn($form);

        $form->createView()->shouldBeCalled()->willReturn($formView);

        $this->editAction($request)->shouldReturn(['form' => $formView, 'user' => $user]);
    }

}

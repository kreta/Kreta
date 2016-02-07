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

namespace spec\Kreta\Bundle\UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Bundle\UserBundle\Manager\OauthManager;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationListenerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class AuthenticationListenerSpec extends ObjectBehavior
{
    function let(OauthManager $manager)
    {
        $this->beConstructedWith($manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\EventListener\AuthenticationListener');
    }

    function it_listens_authorization_event(AuthorizationEvent $event, Request $request, SessionInterface $session)
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getSession()->shouldBeCalled()->willReturn($session);
        $session->get('_email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $session->get('_password')->shouldBeCalled()->willReturn('123456');
        $session->remove('_email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $session->remove('_password')->shouldBeCalled()->willReturn('123456');
        $session->replace(['access_token' => null, 'refresh_token' => null])->shouldBeCalled();

        $this->onAuthorizationEvent($event);
    }

    function it_listens_interactive_login(
        InteractiveLoginEvent $interactiveLoginEvent,
        TokenInterface $token,
        UserInterface $user,
        Request $request,
        SessionInterface $session,
        ParameterBagInterface $parameterBag
    ) {
        $interactiveLoginEvent->getAuthenticationToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $interactiveLoginEvent->getRequest()->shouldBeCalled()->willReturn($request);
        $parameterBag->get('_username')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $parameterBag->get('_password')->shouldBeCalled()->willReturn('123456');
        $request->request = $parameterBag;
        $request->getSession()->shouldBeCalled()->willReturn($session);
        $session->set('_email', 'kreta@kreta.com')->shouldBeCalled();
        $session->set('_password', '123456')->shouldBeCalled();

        $session->get('_email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $session->get('_password')->shouldBeCalled()->willReturn('123456');

        $session->remove('_email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $session->remove('_password')->shouldBeCalled()->willReturn('123456');
        $session->replace(['access_token' => null, 'refresh_token' => null])->shouldBeCalled();

        $this->onInteractiveLogin($interactiveLoginEvent);
    }

    function it_listens_registration_success(
        FormEvent $formEvent,
        FormInterface $form,
        Request $request,
        SessionInterface $session,
        UserInterface $user
    ) {
        $formEvent->getForm()->shouldBeCalled()->willReturn($form);
        $form->getData()->shouldBeCalled()->willReturn($user);
        $formEvent->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getSession()->shouldBeCalled()->willReturn($session);
        $user->getEmail()->shouldBeCalled()->willReturn('kreta@kreta.com');
        $user->getPlainPassword()->shouldBeCalled()->willReturn('123456');
        $session->set('_email', 'kreta@kreta.com')->shouldBeCalled();
        $session->set('_password', '123456')->shouldBeCalled();

        $this->onRegistrationSuccess($formEvent);
    }
}

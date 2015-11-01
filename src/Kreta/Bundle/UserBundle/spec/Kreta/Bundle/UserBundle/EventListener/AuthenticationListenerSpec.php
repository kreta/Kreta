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

use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use FOS\UserBundle\Event\FormEvent;
use Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface;
use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Bundle\UserBundle\Event\CookieEvent;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use OAuth2\OAuth2;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\SessionUnavailableException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationListenerSpec.
 *
 * @package spec\Kreta\Bundle\UserBundle\EventListener
 */
class AuthenticationListenerSpec extends ObjectBehavior
{
    function let(ClientManagerInterface $clientManager, OAuth2 $oauthServer)
    {
        $this->beConstructedWith($clientManager, $oauthServer, 'client-secret');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\EventListener\AuthenticationListener');
    }

    function it_listens_authorization_event(
        ClientManagerInterface $clientManager,
        ClientInterface $client,
        AuthorizationEvent $event,
        Request $request,
        SessionInterface $session,
        OAuth2 $oauthServer,
        Response $response
    )
    {
        $clientManager->findClientBy(['secret' => 'client-secret'])->shouldBeCalled()->willReturn($client);
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getSession()->shouldBeCalled()->willReturn($session);
        $client->getId()->shouldBeCalled()->willReturn('the-public-id');
        $client->getRandomId()->shouldBeCalled()->willReturn('random-id');
        $session->get('_email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $session->get('_password')->shouldBeCalled()->willReturn('123456');
        $oauthServer->grantAccessToken(Argument::type('Symfony\Component\HttpFoundation\Request'))
            ->shouldBeCalled()->willReturn($response);
        $response->getContent()->shouldBeCalled()->willReturn('the response content');
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
        ParameterBagInterface $parameterBag,
        ClientManagerInterface $clientManager,
        ClientInterface $client,
        OAuth2 $oauthServer,
        Response $response
    )
    {
        $interactiveLoginEvent->getAuthenticationToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $interactiveLoginEvent->getRequest()->shouldBeCalled()->willReturn($request);
        $parameterBag->get('_username')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $parameterBag->get('_password')->shouldBeCalled()->willReturn('123456');
        $request->request = $parameterBag;
        $request->getSession()->shouldBeCalled()->willReturn($session);
        $session->set('_email', 'kreta@kreta.com')->shouldBeCalled();
        $session->set('_password', '123456')->shouldBeCalled();

        $clientManager->findClientBy(['secret' => 'client-secret'])->shouldBeCalled()->willReturn($client);

        $client->getId()->shouldBeCalled()->willReturn('the-id');
        $client->getRandomId()->shouldBeCalled()->willReturn('random-id');
        $session->get('_email')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $session->get('_password')->shouldBeCalled()->willReturn('123456');
        $oauthServer->grantAccessToken(Argument::type('Symfony\Component\HttpFoundation\Request'))
            ->shouldBeCalled()->willReturn($response);
        $response->getContent()->shouldBeCalled()->willReturn('the response content');
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
    )
    {
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

    function it_listens_cookie_event(
        CookieEvent $cookieEvent,
        Response $response,
        ResponseHeaderBag $responseHeaderBag,
        SessionInterface $session
    )
    {
        $cookieEvent->getSession()->shouldBeCalled()->willReturn($session);
        $session->has('access_token')->shouldBeCalled()->willReturn(true);
        $session->has('refresh_token')->shouldBeCalled()->willReturn(true);
        $cookieEvent->getResponse()->shouldBeCalled()->willReturn($response);
        $session->get('access_token')->shouldBeCalled()->willReturn('accesstoken');
        $session->get('refresh_token')->shouldBeCalled()->willReturn('refreshtoken');
        $responseHeaderBag->setCookie(Argument::type('Symfony\Component\HttpFoundation\Cookie'))->shouldBeCalled();
        $responseHeaderBag->setCookie(Argument::type('Symfony\Component\HttpFoundation\Cookie'))->shouldBeCalled();
        $response->headers = $responseHeaderBag;

        $this->onCookieEvent($cookieEvent);
    }

    function it_throws_session_unavailable_exception_when_it_listens_cookie_event(
        CookieEvent $cookieEvent,
        SessionInterface $session
    )
    {
        $cookieEvent->getSession()->shouldBeCalled()->willReturn($session);
        $session->has('access_token')->shouldBeCalled()->willReturn(true);
        $session->has('refresh_token')->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new SessionUnavailableException())->during('onCookieEvent', [$cookieEvent]);
    }
}

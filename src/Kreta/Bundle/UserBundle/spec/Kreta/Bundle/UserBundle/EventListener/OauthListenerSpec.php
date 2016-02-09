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

use FOS\OAuthServerBundle\Storage\OAuthStorage;
use Kreta\Bundle\UserBundle\Manager\OauthManager;
use OAuth2\OAuth2;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class OauthListenerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OauthListenerSpec extends ObjectBehavior
{
    function let(
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager,
        OAuth2 $serverService,
        OauthManager $oauthManager,
        OAuthStorage $oauthStorage
    ) {
        $this->beConstructedWith($tokenStorage, $authenticationManager, $serverService, $oauthManager, $oauthStorage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\EventListener\OauthListener');
    }

    function it_extends_fos_oauth_server_bundle_oauth_listener()
    {
        $this->shouldHaveType('FOS\OAuthServerBundle\Security\Firewall\OAuthListener');
    }

    function it_handle(
        GetResponseEvent $event,
        Request $request,
        SessionInterface $session,
        OAuth2 $serverService
    ) {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getSession()->shouldBeCalled()->willReturn($session);
        $session->has('access_token')->shouldBeCalled()->willReturn(true);
        $session->has('refresh_token')->shouldBeCalled()->willReturn(true);
        $session->get('refresh_token')->shouldBeCalled()->willReturn('refreshtoken');
        $serverService->getBearerToken($request)->shouldBeCalled()->willReturn('accesstoken');
        $serverService->getVariable('realm')->shouldBeCalled()->willReturn('realm');
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\Response'))->shouldBeCalled();

        $this->handle($event);
    }
}

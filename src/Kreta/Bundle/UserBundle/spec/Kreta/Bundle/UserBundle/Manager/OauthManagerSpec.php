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

namespace spec\Kreta\Bundle\UserBundle\Manager;

use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\ClientInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\RefreshTokenInterface;
use OAuth2\OAuth2;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OAuthManagerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OauthManagerSpec extends ObjectBehavior
{
    function let(ClientManagerInterface $clientManager, OAuth2 $oauthServer)
    {
        $this->beConstructedWith($clientManager, $oauthServer, 'clientsecret');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\Manager\OauthManager');
    }

    function it_execute_password_grant_type(
        ClientManagerInterface $clientManager,
        ClientInterface $client,
        OAuth2 $oauthServer,
        Response $response
    ) {
        $clientManager->findClientBy(['secret' => 'clientsecret'])->shouldBeCalled()->willReturn($client);
        $client->getId()->shouldBeCalled()->willReturn('clientid');
        $client->getRandomId()->shouldBeCalled()->willReturn('clientrandomid');

        $oauthServer->grantAccessToken(Argument::type('Symfony\Component\HttpFoundation\Request'))
            ->shouldBeCalled()->willReturn($response);
        $response->getContent()->shouldBeCalled()->willReturn('response content');

        $this->password('username', 'password')->shouldBeArray();
    }

    function it_execute_refresh_token_grant_type(
        RefreshTokenInterface $refreshToken,
        ClientManagerInterface $clientManager,
        ClientInterface $client,
        OAuth2 $oauthServer,
        Response $response
    ) {
        $refreshToken->getToken()->shouldBeCalled()->willReturn('refreshtoken');

        $clientManager->findClientBy(['secret' => 'clientsecret'])->shouldBeCalled()->willReturn($client);
        $client->getId()->shouldBeCalled()->willReturn('clientid');
        $client->getRandomId()->shouldBeCalled()->willReturn('clientrandomid');

        $oauthServer->grantAccessToken(Argument::type('Symfony\Component\HttpFoundation\Request'))
            ->shouldBeCalled()->willReturn($response);
        $response->getContent()->shouldBeCalled()->willReturn('response content');

        $this->refreshToken($refreshToken)->shouldBeArray();
    }
}

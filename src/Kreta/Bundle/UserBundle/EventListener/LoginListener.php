<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\EventListener;

use FOS\OAuthServerBundle\Model\AccessTokenManagerInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use FOS\OAuthServerBundle\Util\Random;
use Kreta\Bundle\CoreBundle\Event\AuthorizationEvent;
use Kreta\Bundle\CoreBundle\Factory\TokenFactory;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginListener.
 *
 * @package Kreta\Bundle\UserBundle\EventListener\LoginListener
 */
class LoginListener
{
    /**
     * The token factory.
     *
     * @var \Kreta\Bundle\CoreBundle\Factory\TokenFactory
     */
    protected $tokenFactory;

    /**
     * The access token manager.
     *
     * @var \FOS\OAuthServerBundle\Model\AccessTokenManagerInterface
     */
    protected $accessTokenManager;

    /**
     * The client manager.
     *
     * @var \FOS\OAuthServerBundle\Model\ClientManagerInterface
     */
    protected $clientManager;

    /**
     * Constructor.
     *
     * @param \FOS\OAuthServerBundle\Model\ClientManagerInterface      $clientManager      The client manager
     * @param \Kreta\Bundle\CoreBundle\Factory\TokenFactory            $tokenFactory       The token factory
     * @param \FOS\OAuthServerBundle\Model\AccessTokenManagerInterface $accessTokenManager The access token manager
     */
    public function __construct(
        ClientManagerInterface $clientManager,
        TokenFactory $tokenFactory,
        AccessTokenManagerInterface $accessTokenManager
    )
    {
        $this->clientManager = $clientManager;
        $this->tokenFactory = $tokenFactory;
        $this->accessTokenManager = $accessTokenManager;
    }

    /**
     * If the user is logged generates the access token and sets into response creating a cookie.
     *
     * @param \Kreta\Bundle\CoreBundle\Event\AuthorizationEvent $event The authorization event
     *
     * @return void
     */
    public function onAuthorizationEvent(AuthorizationEvent $event)
    {
        $user = $event->getUser();
        if ($user instanceof UserInterface) {
            $client = $this->clientManager->findClientBy(['randomId' => 'kreta.io']);
            $token = $this->tokenFactory->create($client, $user, Random::generateToken(), time());
            $this->accessTokenManager->updateToken($token);
        }

        $response = new Response();
        $response->headers->setCookie(new Cookie('access_token', $token->getToken(), 0, '/', null, false, false));
        $event->setResponse($response);
    }
}

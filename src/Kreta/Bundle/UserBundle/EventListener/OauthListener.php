<?php

/*
 * This file is part of the FOSOAuthServerBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\UserBundle\EventListener;

use FOS\OAuthServerBundle\Security\Firewall\OAuthListener as BaseOauthListener;
use FOS\OAuthServerBundle\Storage\OAuthStorage;
use Kreta\Bundle\CoreBundle\Model\Interfaces\AccessTokenInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\RefreshTokenInterface;
use Kreta\Bundle\UserBundle\Exception\UnauthorizedException;
use Kreta\Bundle\UserBundle\Manager\OauthManager;
use OAuth2\OAuth2;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * OAuth Listener class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OauthListener extends BaseOauthListener
{
    /**
     * The OAuth manager.
     *
     * @var OauthManager
     */
    protected $oauthManager;

    /**
     * The OAuth storage.
     *
     * @var OAuthStorage
     */
    protected $oauthStorage;

    /**
     * Cnstructor.
     *
     * @param TokenStorageInterface          $tokenStorage          The token storage.
     * @param AuthenticationManagerInterface $authenticationManager The authentication manager.
     * @param OAuth2                         $serverService         The server service
     * @param OauthManager                   $oauthManager          The OAuth manager
     * @param OAuthStorage                   $oauthStorage          The OAuth storage
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager,
        OAuth2 $serverService,
        OauthManager $oauthManager,
        OAuthStorage $oauthStorage
    ) {
        parent::__construct($tokenStorage, $authenticationManager, $serverService);
        $this->oauthManager = $oauthManager;
        $this->oauthStorage = $oauthStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(GetResponseEvent $event)
    {
        $session = $event->getRequest()->getSession();
        if ($session->has('access_token') && $session->has('refresh_token')) {
            try {
                $token = $this->serverService->getBearerToken($event->getRequest());
                if ($session->get('access_token') !== $token) {//&& $session->get('access_token_old') !== $token) {
                    throw new UnauthorizedException($this->serverService, 'access denied');
                }

                list($accessToken, $refreshToken) = $this->refresh(
                    $session->get('access_token'),
                    $session->get('refresh_token')
                );
            } catch (UnauthorizedException $exception) {
                if (null !== $previous = $exception->getPrevious()) {
                    $event->setResponse($previous->getHttpResponse());
                }

                return;
            }
            $session->save();
            $session->set('access_token_old', $session->get('access_token'));
            $session->set('access_token', $accessToken);
            $session->set('refresh_token', $refreshToken);
            $event->getRequest()->setSession($session);

            $this->serverService->getBearerToken($event->getRequest(), true);
            $event->getRequest()->headers->set('AUTHORIZATION', sprintf('Bearer %s', $accessToken));
        }

        parent::handle($event);
    }

    /**
     * Discriminates if the given access and
     * refresh token can executes the refresh grant type.
     *
     * @param string $accessToken  The access token
     * @param string $refreshToken The refresh token
     *
     * @return array
     * @throws UnauthorizedException when the token does no exist
     */
    protected function refresh($accessToken, $refreshToken)
    {
        $access = $this->oauthStorage->getAccessToken($accessToken);
        if (!$access instanceof AccessTokenInterface) {
            throw new UnauthorizedException($this->serverService, 'access denied');
        }
        if (true === $access->hasExpired()) {
            $refresh = $this->oauthStorage->getRefreshToken($refreshToken);
            if (!$refresh instanceof RefreshTokenInterface || $refresh->hasExpired()) {
                throw new UnauthorizedException($this->serverService, 'access denied');
            }

            return $this->oauthManager->refreshToken($refresh);
        }

        return [$accessToken, $refreshToken];
    }
}

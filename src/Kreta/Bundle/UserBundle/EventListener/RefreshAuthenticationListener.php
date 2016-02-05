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

namespace Kreta\Bundle\UserBundle\EventListener;

use FOS\OAuthServerBundle\Model\AccessTokenManagerInterface;
use FOS\OAuthServerBundle\Model\RefreshTokenManagerInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\AccessTokenInterface;
use Kreta\Bundle\CoreBundle\Model\Interfaces\RefreshTokenInterface;
use Kreta\Bundle\UserBundle\Event\CookieEvent;
use Kreta\Bundle\UserBundle\Manager\OauthManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Refresh Authentication listener class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class RefreshAuthenticationListener
{
    /**
     * The access token manager.
     *
     * @var AccessTokenManagerInterface
     */
    protected $accessTokenManager;

    /**
     * The oauth manager.
     *
     * @var OauthManager
     */
    protected $oauthManager;

    /**
     * The refresh token manager.
     *
     * @var RefreshTokenManagerInterface
     */
    protected $refreshTokenManager;

    /**
     * The cookie listener.
     *
     * @var CookieListener
     */
    private $cookieListener;

    /**
     * Constructor.
     *
     * @param OauthManager                 $oauthManager        The oauth manager
     * @param AccessTokenManagerInterface  $accessTokenManager  The access token manager
     * @param RefreshTokenManagerInterface $refreshTokenManager The refresh token manager
     * @param CookieListener               $cookieListener      The cookie listener
     */
    public function __construct(
        OauthManager $oauthManager,
        AccessTokenManagerInterface $accessTokenManager,
        RefreshTokenManagerInterface $refreshTokenManager,
        CookieListener $cookieListener
    ) {
        $this->oauthManager = $oauthManager;
        $this->accessTokenManager = $accessTokenManager;
        $this->refreshTokenManager = $refreshTokenManager;
        $this->cookieListener = $cookieListener;
    }

    /**
     * If the user has an expires access token, it refreshes
     * setting the response and saving inside a cookie.
     *
     * @param GetResponseEvent $event The get response event
     */
    public function onRefresh(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $session = $event->getRequest()->getSession();
        if (!($session->has('access_token')) || !($session->has('refresh_token'))) {
            return;
        }

        try {
            list($accessToken, $refreshToken) = $this->canBeRefresh(
                $session->get('access_token'),
                $session->get('refresh_token')
            );

            $session->set('access_token', $accessToken);
            $session->set('refresh_token', $refreshToken);

            $this->cookieListener->onCookieEvent(new CookieEvent($session, $event->getResponse()));
        } catch (AuthenticationException $exception) {
            $event->setResponse(new RedirectResponse('/logout'));
        }
    }

    /**
     * Discriminates if the given access and
     * refresh token can executes the refresh grant type.
     *
     * @param string $accessToken  The access token
     * @param string $refreshToken The refresh token
     *
     * @return array
     * @throws AuthenticationException when the token does no exist
     */
    protected function canBeRefresh($accessToken, $refreshToken)
    {
        $access = $this->accessTokenManager->findTokenBy(['token' => $accessToken]);
        if (!$access instanceof AccessTokenInterface) {
            throw new AuthenticationException();
        }
        if (true === $access->hasExpired()) {
            $refresh = $this->refreshTokenManager->findTokenBy(['token' => $refreshToken]);
            if (!$refresh instanceof RefreshTokenInterface || $refresh->hasExpired()) {
                throw new AuthenticationException();
            }

            return $this->oauthManager->refreshToken($refresh);
        }

        return [$accessToken, $refreshToken];
    }
}

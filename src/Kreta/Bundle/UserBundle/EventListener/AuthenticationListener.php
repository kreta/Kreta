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

use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use FOS\UserBundle\Event\FormEvent;
use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Bundle\UserBundle\Event\CookieEvent;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\SessionUnavailableException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationListener.
 *
 * @package Kreta\Bundle\UserBundle\EventListener\LoginListener
 */
class AuthenticationListener
{
    /**
     * The client manager.
     *
     * @var \FOS\OAuthServerBundle\Model\ClientManagerInterface
     */
    protected $clientManager;

    /**
     * The client secret.
     *
     * @var string|null
     */
    protected $clientSecret;

    /**
     * The instance of OAuth server.
     *
     * @var \OAuth2\OAuth2
     */
    protected $oauthServer;

    /**
     * Constructor.
     *
     * @param \FOS\OAuthServerBundle\Model\ClientManagerInterface $clientManager The client manager
     * @param \OAuth2\OAuth2                                      $oauthServer   The instance of OAuth server
     * @param string|null                                         $clientSecret  The client secret
     */
    public function __construct(ClientManagerInterface $clientManager, OAuth2 $oauthServer, $clientSecret = null)
    {
        $this->clientManager = $clientManager;
        $this->oauthServer = $oauthServer;
        $this->clientSecret = $clientSecret;
    }

    /**
     * If the user is logged generates the access token and sets into response creating a cookie.
     *
     * @param \Kreta\Bundle\UserBundle\Event\AuthorizationEvent $event The authorization event
     *
     * @return void
     */
    public function onAuthorizationEvent(AuthorizationEvent $event)
    {
        $client = $this->clientManager->findClientBy(['secret' => $this->clientSecret]);
        $session = $event->getRequest()->getSession();
        $request = new Request();
        $request->query->add([
            'grant_type'    => 'password',
            'client_secret' => $this->clientSecret,
            'client_id'     => sprintf('%s_%s', $client->getId(), $client->getRandomId()),
            'username'      => $session->get('_email'),
            'password'      => $session->get('_password'),
        ]);
        $response = $this->oauthServer->grantAccessToken($request);
        $token = json_decode($response->getContent(), true);

        $event->getRequest()->getSession()->remove('_email');
        $event->getRequest()->getSession()->remove('_password');
        $event->getRequest()->getSession()->replace([
            'access_token'  => $token['access_token'],
            'refresh_token' => $token['refresh_token']
        ]);
    }

    /**
     * Listens in the login form saving in the session the username and the plain password.
     *
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event The interactive login event
     *
     * @return void
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if ($user instanceof UserInterface) {
            $request = $event->getRequest();
            $request->getSession()->set('_email', $request->request->get('_username'));
            $request->getSession()->set('_password', $request->request->get('_password'));
            $this->onAuthorizationEvent(new AuthorizationEvent($request));
        }
    }

    /**
     * Listens in the registration form saving in the session the username and the plain password.
     *
     * @param \FOS\UserBundle\Event\FormEvent $event The form event
     *
     * @return void
     */
    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        if ($user instanceof UserInterface) {
            $request = $event->getRequest();
            $request->getSession()->set('_email', $user->getEmail());
            $request->getSession()->set('_password', $user->getPlainPassword());
        }
    }

    /**
     * Checks if the session has the tokens to create cookies that will be add into response.
     *
     * @param \Kreta\Bundle\UserBundle\Event\CookieEvent $event The cookie event
     *
     * @return void
     */
    public function onCookieEvent(CookieEvent $event)
    {
        $session = $event->getSession();
        if (!($session->has('access_token')) || !($session->has('refresh_token'))) {
            throw new SessionUnavailableException();
        }
        $event->getResponse()->headers->setCookie($this->createCookie('access_token', $session->get('access_token')));
        $event->getResponse()->headers->setCookie($this->createCookie('refresh_token', $session->get('refresh_token')));
    }

    /**
     * Creates cookie that its content is the given token.
     *
     * @param string $key   The name of token
     * @param string $value The value of token
     *
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    protected function createCookie($key, $value)
    {
        return new Cookie($key, $value, 0, '/', null, false, false);
    }
}

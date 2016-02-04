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

use FOS\UserBundle\Event\FormEvent;
use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Bundle\UserBundle\Manager\OauthManager;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationListener.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class AuthenticationListener
{
    /**
     * The oauth manager.
     *
     * @var OauthManager
     */
    protected $oauthManager;

    /**
     * Constructor.
     *
     * @param OauthManager $oauthManager The oauth manager
     */
    public function __construct(OauthManager $oauthManager)
    {
        $this->oauthManager = $oauthManager;
    }

    /**
     * If the user is logged generates the access
     * token and sets into response creating a cookie.
     *
     * @param AuthorizationEvent $event The authorization event
     */
    public function onAuthorizationEvent(AuthorizationEvent $event)
    {
        $session = $event->getRequest()->getSession();

        list($accessToken, $refreshToken) = $this->oauthManager->password(
            $session->get('_email'),
            $session->get('_password')
        );

        $event->getRequest()->getSession()->remove('_email');
        $event->getRequest()->getSession()->remove('_password');

        $event->getRequest()->getSession()->replace([
            'access_token'  => $accessToken,
            'refresh_token' => $refreshToken,
        ]);
    }

    /**
     * Listens in the login form saving in the
     * session the username and the plain password.
     *
     * @param InteractiveLoginEvent $event The interactive login event
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
     * Listens in the registration form saving in
     * the session the username and the plain password.
     *
     * @param FormEvent $event The form event
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
}

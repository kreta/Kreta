<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\EventListener;

use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class EmptyProfileListener.
 *
 * @package Kreta\Bundle\WebBundle\EventListener
 */
class EmptyProfileListener
{
    /**
     * The security context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * The router.
     *
     * @var \Symfony\Component\Routing\Router
     */
    protected $router;

    /**
     * The session.
     *
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param SecurityContextInterface $securityContext The security context
     * @param Router                   $router          The router
     * @param Session                  $session         The session
     */
    public function __construct(SecurityContextInterface $securityContext, Router $router, Session $session)
    {
        $this->securityContext = $securityContext;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * Checks if user has an email, if empty redirects to the profile form.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event The response event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        if ($event->getRequest()->attributes->get('_route') === 'kreta_web_user_edit') {
            return;
        }

        $token = $this->securityContext->getToken();
        if ($token !== null && $token->getUser() instanceof UserInterface && $token->getUser()->getEmail() === null) {
            $this->session->getFlashBag()->add('error', 'Email required to start using Kreta');
            $response = new RedirectResponse($this->router->generate('kreta_web_user_edit'));
            $event->setResponse($response);
        }
    }
}

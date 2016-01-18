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

namespace Kreta\Bundle\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CookieEvent.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class CookieEvent extends Event
{
    const NAME = 'kreta_user_event_cookie';

    /**
     * The response.
     *
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * The session.
     *
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session  The session
     * @param \Symfony\Component\HttpFoundation\Response                 $response The response
     */
    public function __construct(SessionInterface $session, Response $response = null)
    {
        $this->session = $session;
        $this->response = $response;
        if (!($this->response instanceof Response)) {
            $this->response = new Response();
        }
    }

    /**
     * Gets response.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets response.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response The response
     *
     * @return $this self Object
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Gets session.
     *
     * @return \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }
}

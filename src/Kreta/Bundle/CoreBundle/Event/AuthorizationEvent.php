<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Event;

use FOS\UserBundle\Event\UserEvent;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthorizationEvent.
 *
 * @package Kreta\Bundle\CoreBundle\Event
 */
class AuthorizationEvent extends UserEvent
{
    const NAME = 'kreta_core_event_authorization';

    /**
     * The response.
     *
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user     The user
     * @param \Symfony\Component\HttpFoundation\Request            $request  The request
     * @param \Symfony\Component\HttpFoundation\Response           $response The response
     */
    public function __construct(UserInterface $user, Request $request, Response $response = null)
    {
        parent::__construct($user, $request);
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
}

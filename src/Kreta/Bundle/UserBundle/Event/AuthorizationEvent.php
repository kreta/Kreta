<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorizationEvent.
 *
 * @package Kreta\Bundle\UserBundle\Event
 */
class AuthorizationEvent extends Event
{
    const NAME = 'kreta_user_event_authorization';

    /**
     * The request.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Gets request.
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}

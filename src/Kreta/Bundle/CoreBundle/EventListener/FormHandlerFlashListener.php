<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\EventListener;

use Kreta\Bundle\CoreBundle\Event\FormHandlerEvent;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class FormHandlerFlashListener.
 *
 * @package Kreta\Bundle\CoreBundle\EventListener
 */
class FormHandlerFlashListener
{
    /**
     * The Session.
     *
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Session\Session $session Will be used to get the FlashBag.
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Listener for onFormHandlerEvent, adds flash message with the given parameters.
     *
     * @param \Kreta\Bundle\CoreBundle\Event\FormHandlerEvent $event Event dispatched.
     *
     * @return void
     */
    public function onFormHandlerEvent(FormHandlerEvent $event)
    {
        $this->session->getFlashBag()->add($event->getType(), $event->getMessage());
    }
} 

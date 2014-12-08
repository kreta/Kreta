<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\EventListener;

use Kreta\Bundle\WebBundle\Event\FormHandlerEvent;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class FormHandlerFlashListener.
 *
 * @package Kreta\Bundle\WebBundle\EventListener
 */
class FormHandlerFlashListener
{
    /**
     * The Session.
     *
     * @var Session
     */
    protected $session;

    /**
     * Construct listener.
     *
     * @param Session $session Will be used to get the FlashBag.
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Listener for onFormHandlerEvent, adds flash message with the given parameters.
     *
     * @param FormHandlerEvent $event Event dispatched.
     */
    public function onFormHandlerEvent(FormHandlerEvent $event)
    {
        $this->session->getFlashBag()->add($event->getType(), $event->getMessage());
    }
} 

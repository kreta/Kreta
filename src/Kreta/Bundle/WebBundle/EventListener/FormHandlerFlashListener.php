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

class FormHandlerFlashListener
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function onFormHandlerEvent(FormHandlerEvent $event)
    {
        $this->session->getFlashBag()->add($event->getType(), $event->getMessage());
    }
} 

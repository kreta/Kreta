<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Controller\Component;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NotificationComponentController extends Controller
{
    /**
     * Renders the icon used to alert users that have notifications
     *
     */
    public function iconAction(Request $request)
    {
        $count = $this->get('kreta_notification.repository.notification')
                    ->getUsersUnreadNotificationsCount($this->getUser());

        return $this->render('KretaWebBundle:Component/Notification:icon.html.twig', ['count' => $count]);
    }
} 

<?php

namespace Kreta\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{
    public function viewAction()
    {
        $notifications = $this->get('kreta_notification.repository_notification')
            ->findAllUnreadByUser($this->getUser());

        return $this->render('KretaWebBundle:Notification:view.html.twig', array('notifications' => $notifications));
    }
} 

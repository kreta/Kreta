<?php

namespace Kreta\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class NotificationController
 *
 * @package Kreta\Bundle\WebBundle\Controller
 */
class NotificationController extends Controller
{
    /**
     * View action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction()
    {
        $notifications = $this->get('kreta_notification.repository_notification')
            ->findAllUnreadByUser($this->getUser());

        return $this->render('KretaWebBundle:Notification:view.html.twig', array('notifications' => $notifications));
    }

    /**
     * Marks notification as read and redirects to the resource contained by the notification.
     *
     * @param string $id The notification id.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function readAction($id)
    {
        /** @var \Kreta\Component\Notification\Model\Interfaces\NotificationInterface $notification */
        $notification = $this->get('kreta_notification.repository_notification')->find($id);

        if (!$notification) {
            $this->createNotFoundException();
        }

        if ($notification->getUser()->getId() !== $this->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $notification->setRead(true);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($notification);
        $manager->flush();

        return $this->redirect($notification->getWebUrl());
    }
} 

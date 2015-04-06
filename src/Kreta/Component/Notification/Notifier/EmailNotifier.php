<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Notifier;

use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface;

/**
 * Class EmailNotifier.
 *
 * @package Kreta\Component\Notification\Notifier
 */
class EmailNotifier implements NotifierInterface
{
    /**
     * The mailer.
     *
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * Constructor.
     *
     * @param \Swift_Mailer $mailer The mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    public function notify(NotificationInterface $notification)
    {
        $message = $this->mailer->createMessage();
        $message
            ->setTo($notification->getUser()->getEmail())
            ->setFrom('notifications@kreta.io')
            ->setSubject($notification->getTitle())
            ->setBody($notification->getDescription());

        $this->mailer->send($message);
    }
}

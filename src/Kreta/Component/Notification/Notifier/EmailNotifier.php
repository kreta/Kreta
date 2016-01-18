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

namespace Kreta\Component\Notification\Notifier;

use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface;

/**
 * Class EmailNotifier.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

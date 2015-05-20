<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\NotificationBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class NotificationContext.
 *
 * @package Kreta\Bundle\NotificationBundle\Behat\Context
 */
class NotificationContext extends DefaultContext
{
    /**
     * Populates the database with notifications.
     *
     * @param \Behat\Gherkin\Node\TableNode $notifications The notifications
     *
     * @return void
     *
     * @Given /^the following notifications exist:$/
     */
    public function theFollowingNotificationsExist(TableNode $notifications)
    {
        foreach ($notifications as $notificationData) {
            $project = $this->get('kreta_project.repository.project')
                ->findOneBy(['name' => $notificationData['project']], false);
            $user = $this->get('kreta_user.repository.user')
                ->findOneBy(['email' => $notificationData['user']], false);

            $notification = $this->get('kreta_notification.factory.notification')->create();

            $notification
                ->setDescription($notificationData['description'])
                ->setProject($project)
                ->setRead($notificationData['read'] === 'true' ? true : false)
                ->setResourceUrl($notificationData['resourceUrl'])
                ->setTitle($notificationData['title'])
                ->setType($notificationData['type'])
                ->setWebUrl($notificationData['webUrl'])
                ->setUser($user);

            if (isset($notificationData['date'])) {
                $this->setField($notification, 'date', new \DateTime($notificationData['date']));
            }
            if (isset($notificationData['id'])) {
                $this->setId($notification, $notificationData['id']);
            }

            $this->get('kreta_notification.repository.notification')->persist($notification);
        }
    }
}

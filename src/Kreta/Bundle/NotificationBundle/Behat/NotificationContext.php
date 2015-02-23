<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\NotificationBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class NotificationContext.
 *
 * @package Kreta\Bundle\NotificationBundle\Behat
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
            $project = $this->container->get('kreta_project.repository.project')
                ->findOneBy(['name' => $notificationData['projectName']], false);
            $user = $this->container->get('kreta_user.repository.user')
                ->findOneBy(['email' => $notificationData['userEmail']], false);

            $notification = $this->container->get('kreta_notification.factory.notification')->create();

            $notification->setDescription($notificationData['description']);
            $notification->setProject($project);
            $notification->setRead($notificationData['read'] === 'true' ? true : false);
            $notification->setResourceUrl($notificationData['resourceUrl']);
            $notification->setTitle($notificationData['title']);
            $notification->setType($notificationData['type']);
            $notification->setWebUrl($notificationData['webUrl']);
            $notification->setUser($user);

            $this->container->get('kreta_notification.repository.notification')->persist($notification);
        }
    }
}

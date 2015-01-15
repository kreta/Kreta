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
        $this->getManager();
        foreach ($notifications as $notificationData) {
            $notification = $this->getContainer()->get('kreta_notification.factory.notification')->create();

            $project = $this->getContainer()->get('kreta_project.repository.project')
                ->findOneBy(['name' => $notificationData['projectName']]);

            if (!$project) {
                throw new \InvalidArgumentException(
                    sprintf('Project %s does not exist', $notificationData['projectName'])
                );
            }

            $user = $this->getContainer()->get('kreta_user.repository.user')
                ->findOneBy(['email' => $notificationData['userEmail']]);

            if (!$user) {
                throw new \InvalidArgumentException(
                    sprintf('User %s does not exist', $notificationData['userEmail'])
                );
            }

            $notification->setDescription($notificationData['description']);
            $notification->setProject($project);
            $notification->setRead($notificationData['read'] === 'true' ? true : false);
            $notification->setResourceUrl($notificationData['resourceUrl']);
            $notification->setTitle($notificationData['title']);
            $notification->setType($notificationData['type']);
            $notification->setWebUrl($notificationData['webUrl']);
            $notification->setUser($user);
            $this->manager->persist($notification);
        }

        $this->manager->flush();
    }
}

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

namespace Kreta\Bundle\NotificationBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class NotificationContext.
 */
class NotificationContext extends DefaultContext
{
    /**
     * Populates the database with notifications.
     *
     * @param \Behat\Gherkin\Node\TableNode $notifications The notifications
     *
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

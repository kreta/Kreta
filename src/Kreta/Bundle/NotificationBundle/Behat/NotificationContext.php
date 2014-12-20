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

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class NotificationContext
 *
 * @package Kreta\Bundle\NotificationBundle\Behat
 */
class NotificationContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following notifications exist:$/
     */
    public function theFollowingNotificationsExist(TableNode $notifications)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach ($notifications as $notificationData) {

            $notification = $this->getKernel()->getContainer()->get('kreta_notification.factory.notification')->create();

            $project = $this->getKernel()->getContainer()->get('kreta_project.repository.project')
                ->findOneBy(['name' => $notificationData['projectName']]);

            if(!$project) {
                throw new \InvalidArgumentException(
                    sprintf('Project %s does not exist', $notificationData['projectName'])
                );
            }

            $user = $this->getKernel()->getContainer()->get('kreta_user.repository.user')
                ->findOneBy(['email' => $notificationData['userEmail']]);

            if(!$user) {
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
            $manager->persist($notification);
        }

        $manager->flush();
    }
}

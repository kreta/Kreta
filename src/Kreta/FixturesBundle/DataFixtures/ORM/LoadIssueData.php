<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\FixturesBundle\DataFixtures\DataFixtures;

/**
 * Class LoadIssueData.
 *
 * @package Kreta\FixturesBundle\DataFixtures\ORM
 */
class LoadIssueData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $users = $this->container->get('kreta_core.repository_user')->findAll();
        $labels = $this->container->get('kreta_core.repository_label')->findAll();

        for ($i = 0; $i < 50; $i++) {
            $issue = $this->container->get('kreta_core.factory_issue')->create();
            $issue->setAssignee($users[array_rand($users)]);
            $issue->setDescription(
                'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
                massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
                quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec
                pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a,
                venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.
                Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu,
                consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi
                vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus
                eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam
                nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.
                Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros
                faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed
                consequat, leo eget bibendum sodales, augue velit cursus nunc'
            );
            $this->loadRandomObjects($issue, 'addLabel', $labels, count($labels));
            $issue->setPriority(rand(0, 3));
            $issue->setResolution(rand(0, 4));
            $issue->setReporter($users[array_rand($users)]);
            $issue->setStatus(rand(0, 2));
            $issue->setType(rand(0, 4));
            $issue->setTitle('Issue - ' . $i);
            $this->loadRandomObjects($issue, 'addWatcher', $users);

            $this->addReference('issue-' . $i, $issue);

            $manager->persist($issue);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}

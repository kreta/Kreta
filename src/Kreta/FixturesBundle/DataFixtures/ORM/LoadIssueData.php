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
            $this->loadRandomObjects($issue, 'addAssigner', $users, count($users));
            $this->loadRandomObjects($issue, 'addLabel', $labels, count($labels));
            $issue->setPriority(rand(0, 3));
            $issue->setResolution(rand(0, 4));
            $issue->setReporter($users[array_rand($users)]);
            $issue->setStatus(rand(0, 2));
            $issue->setType(rand(0, 4));
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

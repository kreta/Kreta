<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures;

/**
 * Class LoadLabelData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadIssueTypeData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $issueTypeNames = ['Bug', 'New Feature', 'Improvement', 'Epic', 'Story'];

        $projects = $this->container->get('kreta_project.repository.project')->findAll();

        foreach ($issueTypeNames as $name) {
            $issueType = $this->container->get('kreta_project.factory.issue_type')
                ->create($projects[array_rand($projects)], $name);

            $manager->persist($issueType);
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

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\DataFixtures\DataFixtures;

/**
 * Class LoadProjectData.
 *
 * @package Kreta\Bundle\CoreBundle\DataFixtures\ORM
 */
class LoadProjectData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $images = $this->loadMedias($manager, 'kreta_core.uploader.image_project', $this->projectPath);
        $users = $this->container->get('kreta_core.repository.user')->findAll();

        for ($i = 0; $i < 10; $i++) {
            $project = $this->container->get('kreta_core.factory.project')->create($users[array_rand($users)]);
            $project->setName('This is the project number ' . $i . ' that is created by fixtures');
            $project->setShortName('PR' . $i);
            $project->setImage($images[$i]);

            $manager->persist($project);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}

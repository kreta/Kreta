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
 * Class LoadRoleData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadRoleData extends DataFixtures
{
    /**
     * Array that contains all the project roles that supports the project.
     *
     * @var string[]
     */
    private $projectRoles = array('ROLE_ADMIN', 'ROLE_PARTICIPANT');

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $projects = $this->container->get('kreta_core.repository_project')->findAll();
        $users = $this->container->get('kreta_core.repository_user')->findAll();

        foreach ($users as $user) {
            $i = rand(0, count($users) - 5);
            $userProjects = array($projects[$i], $projects[$i + 1], $projects[$i + 2], $projects[$i + 3]);
            foreach ($userProjects as $project) {
                $projectRole = $this->container->get('kreta_core.factory_projectRole')->create($project, $user);
                $projectRole->setRole($this->projectRoles[array_rand($this->projectRoles)]);

                $manager->persist($projectRole);
            }
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

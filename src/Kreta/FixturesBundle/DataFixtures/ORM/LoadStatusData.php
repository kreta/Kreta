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
 * Class LoadStatusData.
 *
 * @package Kreta\FixturesBundle\DataFixtures\ORM
 */
class LoadStatusData extends DataFixtures
{
    /**
     * Array that contains all the status that supports Kreta.
     *
     * @var string[]
     */
    private $statusCollection = array('Todo', 'Doing', 'Done');

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->statusCollection as $description) {
            $status = $this->container->get('kreta_core.factory_status')->create();
            $status->setDescription($description);

            $manager->persist($status);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 0;
    }
}

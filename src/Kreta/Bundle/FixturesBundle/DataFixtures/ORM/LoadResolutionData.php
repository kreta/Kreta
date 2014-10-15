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
 * Class LoadResolutionData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadResolutionData extends DataFixtures
{
    /**
     * Array that contains all the resolutions that supports Kreta.
     *
     * @var string[]
     */
    private $resolutionCollection = array('Fixed', "Won't Fix", 'Duplicate', 'Incomplete', 'Cannot Reproduce');

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->resolutionCollection as $description) {
            $resolution = $this->container->get('kreta_core.factory_resolution')->create();
            $resolution->setDescription($description);

            $manager->persist($resolution);
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

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\FixturesBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DataFixture.
 *
 * @package Kreta\FixturesBundle\DataFixtures
 */
abstract class DataFixtures extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * The container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Adds random users into collection of object given.
     *
     * @param Object $object     The object
     * @param string $method     The name of the method
     * @param array  $collection The collection
     * @param int    $limit      The maximum limit of the index
     *
     * @return void
     */
    protected function loadRandomObjects($object, $method, array $collection, $limit = 5)
    {
        $randomAmount = rand(1, $limit);
        $index = rand(0, $limit);

        for ($j = 0; $j < $randomAmount; $j++) {
            if(count($collection) > $index) {
                $object->$method($collection[$index]);
                $index++;
            }
        }
    }
}

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Behat\Traits;

use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

/**
 * Trait DatabaseContextTrait.
 *
 * @package Kreta\Bundle\CoreBundle\Behat\Traits
 */
trait DatabaseContextTrait
{
    use KernelDictionary;

    /**
     * The entity manager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Gets entity manager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getManager()
    {
        return $this->manager = $this->getContainer()->get('doctrine')->getManager();
    }

    /**
     * Method that allows to purge database before load the scenario.
     *
     * @return void
     *
     * @BeforeScenario
     */
    public function purgeDatabase()
    {
        $this->getManager();
        $this->manager->getConnection()->executeUpdate('SET foreign_key_checks = 0;');

        $purger = new ORMPurger($this->manager);
        $purger->purge();

        $this->manager->getConnection()->executeUpdate('SET foreign_key_checks = 1;');
    }
}

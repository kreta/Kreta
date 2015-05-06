<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Behat;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

/**
 * Class DefaultContext.
 *
 * @package Kreta\Bundle\CoreBundle\Behat
 */
class DefaultContext extends RawMinkContext implements KernelAwareContext
{
    use KernelDictionary;

    /**
     * Method that allows to purge database before load the scenario.
     *
     * @return void
     *
     * @BeforeScenario
     */
    public function purgeDatabase()
    {
        $connection = $this->getManager()->getConnection();

        $connection->executeUpdate('SET foreign_key_checks = 0;');

        $purger = new ORMPurger($this->getManager());
        $purger->purge();

        $connection->executeUpdate('SET foreign_key_checks = 1;');
    }

    /**
     * Gets a service by id.
     *
     * @param string $id The service id
     *
     * @return object
     */
    public function get($id)
    {
        return $this->kernel->getContainer()->get($id);
    }

    /**
     * Gets the the doctrine's entity manager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * Sets id.
     *
     * @param Object $object The object that will be set
     * @param string $id     The id
     *
     * @return void
     */
    public function setId($object, $id)
    {
        $metadata = $this->getManager()->getClassMetaData(get_class($object));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdentifierValues($object, ['id' => $id]);
    }

    /**
     * Sets the field given with value given.
     *
     * @param Object $object The object that will be set
     * @param string $field  The field
     * @param mixed  $value  The value
     *
     * @return void
     */
    public function setField($object, $field, $value)
    {
        $metadata = $this->getManager()->getClassMetaData(get_class($object));
        $metadata->setFieldValue($object, $field, $value);
    }
}

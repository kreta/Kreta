<?php

/**
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
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class DefaultContext.
 *
 * @package Kreta\Bundle\CoreBundle\Behat
 */
class DefaultContext extends RawMinkContext implements KernelAwareContext
{
    /**
     * The container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    protected $kernel;

    /**
     * The entity manager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->container = $this->kernel->getContainer();
        $this->manager = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
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
        $this->manager->getConnection()->executeUpdate('SET foreign_key_checks = 0;');

        $purger = new ORMPurger($this->manager);
        $purger->purge();

        $this->manager->getConnection()->executeUpdate('SET foreign_key_checks = 1;');
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
        $metadata = $this->manager->getClassMetaData(get_class($object));
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
        $metadata = $this->manager->getClassMetaData(get_class($object));
        $metadata->setFieldValue($object, $field, $value);
    }
}

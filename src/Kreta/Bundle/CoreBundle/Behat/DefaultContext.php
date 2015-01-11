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
use Kreta\Bundle\CoreBundle\Behat\Traits\DatabaseContextTrait;

/**
 * Class DefaultContext.
 *
 * @package Kreta\Bundle\CoreBundle\Behat
 */
class DefaultContext extends RawMinkContext implements KernelAwareContext
{
    use DatabaseContextTrait;

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

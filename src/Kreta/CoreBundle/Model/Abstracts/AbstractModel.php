<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\CoreBundle\Model\Abstracts;

/**
 * Abstract class AbstractModel.
 *
 * @package Kreta\CoreBundle\Model\Abstracts
 */
abstract class AbstractModel
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * Sets id.
     *
     * @param string $id The id
     *
     * @return $this self Object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Magic method that is useful in Twig templates representing the entity class into string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}

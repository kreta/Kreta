<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Component\Core\Model\Abstracts;

/**
 * Abstract class AbstractModel.
 *
 * @package Kreta\Component\Core\Model\Abstracts
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

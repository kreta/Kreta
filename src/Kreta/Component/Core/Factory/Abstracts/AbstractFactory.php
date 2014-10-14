<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Factory\Abstracts;

/**
 * Abstract class AbstractFactory.
 *
 * @package Kreta\Component\Core\Factory\Abstracts
 */
abstract class AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return Object
     */
    abstract public function create();
}

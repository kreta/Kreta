<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Model\Status;

/**
 * Class StatusFactory.
 *
 * @package Kreta\Component\Core\Factory
 */
class StatusFactory
{
    /**
     * Creates an instance of Status.
     *
     * @param string $name        The name
     * @param string $type        The type
     * @param array  $transitions Array that contains transitions
     * @param array  $properties  Array that contains properties
     *
     * @return \Kreta\Component\Core\Model\Status
     */
    public function create(
        $name,
        $type = StatusInterface::TYPE_NORMAL,
        array $transitions = array(),
        array $properties = array()
    )
    {
        return new Status($name, $type, $transitions, $properties);
    }
}

<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Serializer\Interfaces;

/**
 * Interface SerializerInterface.
 *
 * @package Kreta\Component\VCS\Serializer\Interfaces
 */
interface SerializerInterface
{
    /**
     * Transforms json message received into a object.
     *
     * @param string $json Raw message received in json format
     *
     * @return Object
     */
    public function deserialize($json);
}

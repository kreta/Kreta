<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Serializer\Registry;

/**
 * Class NonExistingSerializerException
 *
 * @package Kreta\Component\VCS\Serializer\Registry
 */
class NonExistingSerializerException extends \InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $provider
     * @param string $event
     */
    public function __construct($provider, $event)
    {
        parent::__construct(sprintf('Serializer for "%s"\'s "%s" event does not exist', $provider, $event));
    }
}

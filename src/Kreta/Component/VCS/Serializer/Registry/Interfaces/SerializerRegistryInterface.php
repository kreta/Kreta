<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Serializer\Registry\Interfaces;

use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;

/**
 * Interface SerializerRegistryInterface.
 *
 * @package Kreta\Component\VCS\Serializer\Registry\Interfaces
 */
interface SerializerRegistryInterface
{
    /**
     * Returns all the serializers for the given provider.
     *
     * @param string $provider For example GitHub
     *
     * @return array with events as keys
     */
    public function getSerializers($provider);

    /**
     * Adds the given serializer to serializer array.
     *
     * @param string                                                         $provider   Provider name. e.g. 'github'
     * @param string                                                         $event      Event name. e.g. 'push'
     * @param \Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface $serializer Serializer that parses event
     *
     * @throws \Kreta\Component\VCS\Serializer\Registry\ExistingSerializerException if serializers already exists
     */
    public function registerSerializer($provider, $event, SerializerInterface $serializer);

    /**
     * Deletes the serializer from the array for the given parameters.
     *
     * @param string $provider Name of the provider. For example 'github'
     * @param string $event    Name of the event. Fore example 'push'
     *
     * @throws \Kreta\Component\VCS\Serializer\Registry\NonExistingSerializerException if serializers does not exist
     */
    public function unregisterSerializer($provider, $event);

    /**
     * Checks if the serializer for the given parameter exists in the array.
     *
     * @param string $provider Name of the provider. For example 'github'
     * @param string $event    Name of the event. Fore example 'push'
     *
     * @return boolean
     */
    public function hasSerializer($provider, $event);

    /**
     * Gets the serializer for the given parameters.
     *
     * @param string $provider Name of the provider. For example 'github'
     * @param string $event    Name of the event. Fore example 'push'
     *
     * @throws \Kreta\Component\VCS\Serializer\Registry\NonExistingSerializerException if serializers does not exist
     * @return \Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface
     */
    public function getSerializer($provider, $event);
}

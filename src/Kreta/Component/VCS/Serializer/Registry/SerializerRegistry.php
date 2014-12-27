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

use Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface;

/**
 * Class SerializerRegistry
 *
 * @package Kreta\Component\VCS\Serializer\Registry
 */
class SerializerRegistry implements SerializerRegistryInterface
{
    protected $serializers = [];

    /**
     * @{@inheritdoc}
     */
    public function getSerializers($provider)
    {
        if (isset($this->serializers[$provider])) {
            return $this->serializers[$provider];
        }

        throw new NonExistingSerializerException($provider, '');
    }

    /**
     * @{@inheritdoc}
     */
    public function registerSerializer($provider, $event, SerializerInterface $notifier)
    {
        if ($this->hasSerializer($provider, $event)) {
            throw new ExistingSerializerException($provider, $event);
        }

        // Initialize providers array if it has not been initialized yet.
        if (!isset($this->serializers[$provider])) {
            $this->serializers[$provider] = [];
        }

        $this->serializers[$provider][$event] = $notifier;
    }

    /**
     * @{@inheritdoc}
     */
    public function unregisterSerializer($provider, $event)
    {
        if (!$this->hasSerializer($provider, $event)) {
            throw new NonExistingSerializerException($provider, $event);
        }

        unset($this->serializers[$provider][$event]);
    }

    /**
     * @{@inheritdoc}
     */
    public function hasSerializer($provider, $event)
    {
        return isset($this->serializers[$provider]) && isset($this->serializers[$provider][$event]);
    }

    /**
     * @{@inheritdoc}
     */
    public function getSerializer($provider, $event)
    {
        if (!$this->hasSerializer($provider, $event)) {
            throw new NonExistingSerializerException($provider, $event);
        }

        return $this->serializers[$provider][$event];
    }
} 

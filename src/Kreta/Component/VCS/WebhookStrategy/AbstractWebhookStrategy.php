<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\WebhookStrategy;

use Kreta\Component\VCS\Serializer\Registry\SerializerRegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WebhookStrategyInterface
 *
 * @package Kreta\Component\VCS\WebhookStrategy\Interfaces
 */
abstract class AbstractWebhookStrategy
{
    /** @var SerializerRegistryInterface $serializerRegistry */
    protected $serializerRegistry;

    /**
     * Constructor.
     *
     * @param SerializerRegistryInterface $serializerRegistry filled with serializers available.
     */
    public function __construct(SerializerRegistryInterface $serializerRegistry)
    {
        $this->serializerRegistry = $serializerRegistry;
    }

    /**
     * Decides which serializer should be used for the given request and returns it
     *
     * @param Request $request The request done by the webhook
     *
     * @throws \Kreta\Component\VCS\Serializer\Registry\NonExistingSerializerException
     * @return \Kreta\Component\VCS\Serializer\Interfaces\SerializerInterface
     */
    abstract public function getSerializer(Request $request);
} 

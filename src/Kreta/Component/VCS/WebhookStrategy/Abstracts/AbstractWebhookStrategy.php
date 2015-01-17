<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\WebhookStrategy\Abstracts;

use Kreta\Component\VCS\Serializer\Registry\Interfaces\SerializerRegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract class WebhookStrategyInterface.
 *
 * @package Kreta\Component\VCS\WebhookStrategy\Interfaces\Abstracts
 */
abstract class AbstractWebhookStrategy
{
    /**
     * The serializer registry.
     *
     * @var \Kreta\Component\VCS\Serializer\Registry\Interfaces\SerializerRegistryInterface
     */
    protected $serializerRegistry;

    /**
     * Constructor.
     *
     * @param SerializerRegistryInterface $serializerRegistry Serializer
     */
    public function __construct(SerializerRegistryInterface $serializerRegistry)
    {
        $this->serializerRegistry = $serializerRegistry;
    }

    /**
     * Decides which serializer should be used for the given request and returns it.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The request done by the webhook
     *
     * @abstract
     */
    abstract public function getSerializer(Request $request);
}

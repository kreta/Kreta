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

declare(strict_types=1);

namespace Kreta\Notifier\Infrastructure\Serialization\JMS;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Kreta\SharedKernel\Serialization\Serializer;

final class JMSSerializer implements Serializer
{
    private $serializer;
    private $format;

    public function __construct(string $format = 'json')
    {
        $this->serializer = $this->serializer();
        $this->format = $format;
    }

    public function serialize($object) : string
    {
        return $this->serializer->serialize($object, $this->format);
    }

    public function deserialize(string $serializedObject, string $type)
    {
        return $this->serializer->deserialize($serializedObject, $type, $this->format);
    }

    private function serializer() : SerializerInterface
    {
        return SerializerBuilder::create()
            ->addMetadataDir(
                __DIR__ . '/../../../../../../vendor/kreta/shared-kernel/src/Kreta/SharedKernel' .
                '/Infrastructure/Serialization/JMS/Config/Identity',
                'Kreta\\SharedKernel\\Domain\\Model\\Identity')
            ->addMetadataDir(__DIR__ . '/Config/Inbox', 'Kreta\\Notifier\\Domain\\Model\\Inbox')
            ->setCacheDir(__DIR__ . '/../../../../../../var/cache/jms-serializer')
            ->build();
    }
}

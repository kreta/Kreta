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

namespace Kreta\SharedKernel\Infrastructure\Serialization\SimpleBus;

use Kreta\SharedKernel\Event\AsyncEvent;
use Kreta\SharedKernel\Serialization\AsyncEventSerializer;
use SimpleBus\Serialization\Envelope\DefaultEnvelope;
use SimpleBus\Serialization\ObjectSerializer;

class SimpleBusAsyncEventSerializer implements ObjectSerializer
{
    private $asyncEventSerializer;

    public function __construct(AsyncEventSerializer $asyncEventSerializer)
    {
        $this->asyncEventSerializer = $asyncEventSerializer;
    }

    public function serialize($object) : string
    {
        if ($object instanceof DefaultEnvelope) {
            return $this->asyncEventSerializer->serialize($object->message());
        }

        return $this->asyncEventSerializer->serialize($object);
    }

    public function deserialize($serializedObject, $type) : ?DefaultEnvelope
    {
        if ($type === DefaultEnvelope::class) {
            return DefaultEnvelope::forSerializedMessage(
                AsyncEvent::class,
                $serializedObject
            );
        }
        $this->asyncEventSerializer->deserialize($serializedObject);
    }
}

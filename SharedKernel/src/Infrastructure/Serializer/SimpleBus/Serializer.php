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

namespace Kreta\SharedKernel\Infrastructure\Serializer\SimpleBus;

use Kreta\SharedKernel\Event\AsyncEvent;
use SimpleBus\Serialization\Envelope\DefaultEnvelope;
use SimpleBus\Serialization\ObjectSerializer;

class Serializer implements ObjectSerializer
{
    public function serialize($object)
    {
        if ($object instanceof DefaultEnvelope) {
            return json_encode([
                'name'       => 'identity_access.user_register',
                'occurredOn' => $object->message()->occurredOn()->format('Y-m-d H:i:s'),
                'values'     => [
                    'user_id' => 'id',
                    'email'   => 'ajksdhajks@asda.com',
                ],
            ]);
        }

        return json_encode([
            'name'       => 'identity_access.user_register',
            'occurredOn' => $object->occurredOn()->format('Y-m-d H:i:s'),
            'values'     => [
                'user_id' => 'id',
                'email'   => 'ajksdhajks@asda.com',
            ],
        ]);
    }

    public function deserialize($serializedObject, $type)
    {
        if ($type === DefaultEnvelope::class) {
            return DefaultEnvelope::forSerializedMessage(
                AsyncEvent::class, $serializedObject
            );
        }

        if ($type === AsyncEvent::class) {
            $serializedObject = json_decode($serializedObject, true);

            if (!isset($serializedObject['name'])
                || !isset($serializedObject['occurredOn'])
                || !isset($serializedObject['values'])
            ) {
                throw new \Exception();
            }

            return new AsyncEvent(
                $serializedObject['name'],
                new \DateTimeImmutable($serializedObject['occurredOn']),
                $serializedObject['values']
            );
        }

        throw new \Exception('Object not supported');
    }
}

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

namespace Kreta\SharedKernel\Serialization;

use BenGorUser\User\Domain\Model\Event\UserEvent;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Event\AsyncEvent;

class AsyncEventSerializer implements Serializer
{
    private $resolver;

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function serialize($event) : string
    {
        // trade off checking if it is a userEvent instance
        // because IdentityAccess BC extends BenGorUser ecosystem
        if (!$event instanceof DomainEvent && !$event instanceof UserEvent) {
            throw new InvalidSerializationObjectException(
                DomainEvent::class,
                get_class($event)
            );
        }

        return json_encode([
            'name'       => $this->resolver->resolve(get_class($event)),
            'occurredOn' => $event->occurredOn()->format('Y-m-d H:i:s'),
            'values'     => $this->propertyValuesFrom($event),
        ]);
    }

    public function deserialize(string $serializedObject, string $type) : AsyncEvent
    {
        $decodedObject = json_decode($serializedObject, true);
        if (!isset($decodedObject['name'])
            || !isset($decodedObject['occurredOn'])
            || !isset($decodedObject['values'])
        ) {
            throw new Exception(
                'Unserialized object needs "name", "occurredOn" and "values" to be constructed'
            );
        }

        return new AsyncEvent(
            $decodedObject['name'],
            new \DateTimeImmutable($decodedObject['occurredOn']),
            $decodedObject['values']
        );
    }

    private function propertyValuesFrom($event) : array
    {
        $values = [];
        $reflectionClass = new \ReflectionClass($event);
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($event);
            if ($value instanceof \DateTimeInterface) {
                $value = $value->format('Y-m-d H:i:s');
            }
            $values[$property->getName()] = (string) $value;
        }

        return $values;
    }
}

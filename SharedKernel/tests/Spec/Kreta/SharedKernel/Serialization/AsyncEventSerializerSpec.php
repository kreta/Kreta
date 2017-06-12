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

namespace Spec\Kreta\SharedKernel\Serialization;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Event\AsyncEvent;
use Kreta\SharedKernel\Serialization\AsyncEventSerializer;
use Kreta\SharedKernel\Serialization\InvalidSerializationObjectException;
use Kreta\SharedKernel\Serialization\Resolver;
use Kreta\SharedKernel\Serialization\Serializer;
use Kreta\SharedKernel\Tests\Double\Domain\Model\DomainEventStub;
use PhpSpec\ObjectBehavior;

class AsyncEventSerializerSpec extends ObjectBehavior
{
    function let(Resolver $resolver)
    {
        $this->beConstructedWith($resolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AsyncEventSerializer::class);
        $this->shouldImplement(Serializer::class);
    }

    function it_serializes(Resolver $resolver)
    {
        $event = new DomainEventStub('foo', 'bar', new \DateTimeImmutable('2016-11-06 23:02:21'));
        $resolver->resolve(DomainEventStub::class)->shouldBeCalled()->willReturn('event-name');
        $this->serialize($event)->shouldReturn(
            '{"name":"event-name","occurredOn":"2016-11-06 23:02:21","values":{"bar":"bar","foo":"foo","occurredOn":"2016-11-06 23:02:21"}}'
        );
    }

    function it_does_not_serialize_when_event_is_not_instance_of_domain_event($notDomainEvent)
    {
        $this->shouldThrow(InvalidSerializationObjectException::class)->duringSerialize($notDomainEvent);
    }

    function it_deserializes()
    {
        $this->deserialize(
            '{"name":"event-name","occurredOn":"2016-11-06 23:02:21","values":{"bar":"bar","foo":"foo","occurredOn":"2016-11-06 23:02:21"}}'
        )->shouldReturnAnInstanceOf(AsyncEvent::class);
    }

    function it_does_not_deserialize_when_name_or_occurred_on_or_values_do_not_exist()
    {
        $this->shouldThrow(Exception::class)->duringDeserialize(
            '{"name":"event-name","values":{"bar":"bar","foo":"foo","occurredOn":"2016-11-06 23:02:21"}}'
        );
    }
}

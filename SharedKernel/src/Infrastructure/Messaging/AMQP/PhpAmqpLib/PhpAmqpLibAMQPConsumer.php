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

namespace Kreta\SharedKernel\Infrastructure\Messaging\AMQP\PhpAmqpLib;

use Kreta\SharedKernel\Domain\Event\AsyncEventSubscriber;
use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Event\AsyncEvent;
use Kreta\SharedKernel\Messaging\AMQP\AMQPConsumer;
use PhpAmqpLib\Message\AMQPMessage;

class PhpAmqpLibAMQPConsumer implements AMQPConsumer
{
    const MSG_ACK = 1;
    const MSG_REJECT = -1;

    private $eventSubscriber;
    private $messageName;

    public function __construct(AsyncEventSubscriber $eventSubscriber, string $messageName)
    {
        $this->eventSubscriber = $eventSubscriber;
        $this->messageName = $messageName;
    }

    public function execute($message) : int
    {
        if (!$message instanceof AMQPMessage) {
            return self::MSG_REJECT;
        }
        $body = json_decode($message->body);
        if ($this->messageName !== $body->name) {
            return self::MSG_REJECT;
        }

        try {
            $this->eventSubscriber->handle(
                new AsyncEvent(
                    $this->messageName,
                    new \DateTimeImmutable($body->occurredOn),
                    json_decode(
                        json_encode(
                            $body->values
                        ),
                        true
                    )
                )
            );

            return self::MSG_ACK;
        } catch (Exception $exception) {
            return self::MSG_REJECT;
        }
    }
}

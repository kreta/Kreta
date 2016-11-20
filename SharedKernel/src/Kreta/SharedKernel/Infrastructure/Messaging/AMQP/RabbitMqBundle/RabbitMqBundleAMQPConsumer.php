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

namespace Kreta\SharedKernel\Infrastructure\Messaging\AMQP\RabbitMqBundle;

use Kreta\SharedKernel\Infrastructure\Messaging\AMQP\PhpAmqpLib\PhpAmqpLibAMQPConsumer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqBundleAMQPConsumer implements ConsumerInterface
{
    private $consumer;

    public function __construct(PhpAmqpLibAMQPConsumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function execute(AMQPMessage $message)
    {
        return $this->consumer->execute($message);
    }
}

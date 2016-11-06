<?php

namespace Kreta\TaskManager\Domain\Event\User;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class UserRegisteredSubscriber implements ConsumerInterface
{
    public function execute(AMQPMessage $message)
    {
        file_put_contents(__DIR__ . '/../../../../../foo.yml', get_class($message));
//        return $event;
    }

    public function handle($message)
    {
        file_put_contents(__DIR__ . '/../../../../../foo.yml', get_class($message));
//        return $event;
    }
}

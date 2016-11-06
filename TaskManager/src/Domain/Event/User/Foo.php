<?php

namespace Kreta\TaskManager\Domain\Event\User;

use SimpleBus\RabbitMQBundleBridge\Event\Events;
use SimpleBus\RabbitMQBundleBridge\Event\MessageConsumed;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Foo implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [Events::MESSAGE_CONSUMED => 'messageConsumed'];
    }

    public function messageConsumed(MessageConsumed $event)
    {
        file_put_contents(__DIR__ . '/../../../../../foo.yml', $event->message()->body);
    }
}

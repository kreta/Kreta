<?php

namespace Kreta\TaskManager\Domain\Event\User;

use SimpleBus\RabbitMQBundleBridge\Event\Events;
use SimpleBus\RabbitMQBundleBridge\Event\MessageConsumptionFailed;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Foo2 implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [Events::MESSAGE_CONSUMPTION_FAILED => 'messageConsumptionFailed'];
    }

    public function messageConsumptionFailed(MessageConsumptionFailed $event)
    {
        file_put_contents(__DIR__ . '/../../../../../foo.yml', $event->exception()->getTraceAsString());
    }
}

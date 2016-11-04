<?php

namespace Kreta\IdentityAccess\Domain\Event;

class FooSubscriber
{
    public function handle($event)
    {
        file_put_contents(__DIR__ . '/../../../../foo.yml', get_class($event) . ' ' . $event->name() . ' '. json_encode($event->values()));
        return $event;
    }
}

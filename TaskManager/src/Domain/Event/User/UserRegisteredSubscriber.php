<?php

namespace Kreta\TaskManager\Domain\Event\User;

class UserRegisteredSubscriber
{
    public function handle($event)
    {
        file_put_contents(__DIR__ . '/../../../../../foo.yml', get_class($event) . ' ' . $event->name() . ' '. json_encode($event->values()));
        return $event;
    }
}

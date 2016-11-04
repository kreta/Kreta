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

declare(strict_types = 1);

namespace Kreta\SharedKernel\Infrastructure\Event\SimpleBus\Name;

use Kreta\SharedKernel\Event\Event;
use SimpleBus\Message\Name\MessageNameResolver;

class CustomNameResolver implements MessageNameResolver
{
    public function resolve($message)
    {
        file_put_contents(__DIR__ . '/../../../../../../foo.yml', get_class($message));

        if(!$message instanceof Event) {
            throw new \Exception('Event must be an event');
        }

        return $message->name();
    }
}

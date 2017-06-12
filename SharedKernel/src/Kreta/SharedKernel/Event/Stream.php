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

namespace Kreta\SharedKernel\Event;

use Kreta\SharedKernel\Domain\Model\DomainEventCollection;

class Stream
{
    private $name;
    private $events;

    public function __construct(StreamName $name, DomainEventCollection $events)
    {
        $this->name = $name;
        $this->events = $events;
    }

    public function name() : StreamName
    {
        return $this->name;
    }

    public function events() : DomainEventCollection
    {
        return $this->events;
    }
}

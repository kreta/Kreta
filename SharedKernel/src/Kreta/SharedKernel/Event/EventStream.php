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
use Kreta\SharedKernel\Domain\Model\Identity\BaseId as Id;

class EventStream
{
    private $aggregateRootId;
    private $events;

    public function __construct(Id $aggregateRootId, DomainEventCollection $events)
    {
        $this->aggregateRootId = $aggregateRootId;
        $this->events = $events;
    }

    public function aggregateRootId() : Id
    {
        return $this->aggregateRootId;
    }

    public function events() : DomainEventCollection
    {
        return $this->events;
    }
}

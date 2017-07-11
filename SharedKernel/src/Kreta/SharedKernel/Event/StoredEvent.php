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

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class StoredEvent implements DomainEvent
{
    private $order;
    private $name;
    private $event;

    public function __construct(int $order, StreamName $name, DomainEvent $event)
    {
        $this->order = $order;
        $this->name = $name;
        $this->event = $event;
    }

    public function order() : int
    {
        return $this->order;
    }

    public function name() : string
    {
        return $this->order() . '@' . $this->name->name();
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->event->occurredOn();
    }

    public function event() : DomainEvent
    {
        return $this->event;
    }
}

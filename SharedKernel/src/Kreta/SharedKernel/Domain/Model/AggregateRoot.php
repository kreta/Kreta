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

namespace Kreta\SharedKernel\Domain\Model;

abstract class AggregateRoot
{
    private $recordedEvents = [];

    public function recordedEvents() : array
    {
        return $this->recordedEvents;
    }

    public function clearEvents() : void
    {
        $this->recordedEvents = [];
    }

    protected function publish(DomainEvent $event) : void
    {
        $this->apply($event);
        $this->record($event);
    }

    protected function apply(DomainEvent $event) : void
    {
        $modifier = 'apply' . array_reverse(explode('\\', get_class($event)))[0];
        if (!method_exists($this, $modifier)) {
            return;
        }
        $this->$modifier($event);
    }

    private function record(DomainEvent $event) : void
    {
        $this->recordedEvents[] = $event;
    }
}

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

namespace Kreta\SharedKernel\Tests\Double\Domain\Model;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Event\Stream;

class AggregateRootStub extends AggregateRoot implements EventSourcedAggregateRoot
{
    private $id;
    private $property;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }

    public function id() : Id
    {
        return $this->id;
    }

    public function property() : string
    {
        return $this->property;
    }

    public function foo()
    {
        $this->publish(new EventSourcingEventStub());
    }

    public function bar()
    {
        $this->property = 'bar';
        $this->publish(new CqrsEventStub());
    }

    protected function applyEventSourcingEventStub()
    {
        $this->property = 'foo';
    }

    public static function reconstitute(Stream $stream) : self
    {
        $instance = new self($stream->name()->aggregateId());

        foreach ($stream as $event) {
            $instance->apply($event);
        }

        return $instance;
    }
}

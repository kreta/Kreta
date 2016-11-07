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

use Kreta\SharedKernel\Domain\Model\DomainEvent;

class DomainEventStub implements DomainEvent
{
    private $bar;
    private $foo;
    private $occurredOn;

    public function __construct($foo, $bar, $occurredOn = null)
    {
        $this->bar = $bar;
        $this->foo = $foo;
        $this->occurredOn = !$occurredOn instanceof \DateTimeInterface ? new \DateTimeImmutable() : $occurredOn;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }

    public function bar() : string
    {
        return $this->bar;
    }

    public function foo() : string
    {
        return $this->foo;
    }
}

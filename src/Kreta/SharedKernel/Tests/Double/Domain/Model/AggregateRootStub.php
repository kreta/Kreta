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

class AggregateRootStub extends AggregateRoot
{
    private $property;

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
}

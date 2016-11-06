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

use Kreta\SharedKernel\Domain\Model\AsyncDomainEvent;

class AsyncEvent implements AsyncDomainEvent
{
    private $name;
    private $occurredOn;
    private $values;

    public function __construct($name, \DateTimeInterface $occurredOn, array $values)
    {
        $this->name = $name;
        $this->occurredOn = $occurredOn;
        $this->values = $values;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function values() : array
    {
        return $this->values;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}

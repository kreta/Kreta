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

class Event
{
    private $name;
    private $values;

    public function __construct($name, $values)
    {
        $this->name = $name;
        $this->values = $values;
    }

    public function name()
    {
        return $this->name;
    }

    public function values()
    {
        return $this->values;
    }
}

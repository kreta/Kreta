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

use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;

class StreamNameIsEmpty extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Event stream name must not be empty');
    }
}

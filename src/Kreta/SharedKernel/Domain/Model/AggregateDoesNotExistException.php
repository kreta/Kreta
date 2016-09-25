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

class AggregateDoesNotExistException extends Exception
{
    public function __construct($aggregateId)
    {
        parent::__construct(sprintf('Does not exist any aggregate with "%s" id', $aggregateId));
    }
}

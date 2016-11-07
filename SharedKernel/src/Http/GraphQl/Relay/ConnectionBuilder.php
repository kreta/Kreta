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

namespace Kreta\SharedKernel\Http\GraphQl\Relay;

interface ConnectionBuilder
{
    public function fromArraySlice($arraySlice, $args, array $meta);

    public function getOffsetWithDefault($cursor, $defaultOffset) : int;
}

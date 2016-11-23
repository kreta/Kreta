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

namespace Kreta\SharedKernel\Infrastructure\Http\GraphQl\OverblogGraphQlBundle\Relay;

use Kreta\SharedKernel\Http\GraphQl\Relay\ConnectionBuilder;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder as BaseConnectionBuilder;

class OverblogGraphQlBundleConnectionBuilder implements ConnectionBuilder
{
    public function fromArraySlice($arraySlice, $args, array $meta)
    {
        return BaseConnectionBuilder::connectionFromArraySlice($arraySlice, $args, $meta);
    }

    public function getOffsetWithDefault($cursor, $defaultOffset) : int
    {
        return BaseConnectionBuilder::getOffsetWithDefault($cursor, $defaultOffset);
    }
}

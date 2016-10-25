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

declare(strict_types = 1);

namespace Kreta\TaskManager\Infrastructure\Ui\Web\Api\GraphQL\Query\Organization;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfIdQuery;
use Kreta\TaskManager\Infrastructure\Ui\Web\Api\GraphQL\Query\Resolver;

class OrganizationResolver implements Resolver
{
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function resolve($args)
    {
        if (isset($args['id'])) {
            $this->queryBus->handle(
                new OrganizationOfIdQuery(
                    $args['id']
                ),
                $result
            );

            return $result;
        }
        $name = isset($args['name']) ? $args['name'] : null;
        $first = isset($args['first']) ? $args['first'] : null; // LIMIT
        $after = isset($args['after']) ? $args['after'] : null; // It's like offset but opaque cursor

//        $this->queryBus->handle(
//            new OrganizationsOfNameQuery(
//                $name,
//                $first,
//                $after
//            ),
//            $result
//        );
//
//        return $result;
    }
}

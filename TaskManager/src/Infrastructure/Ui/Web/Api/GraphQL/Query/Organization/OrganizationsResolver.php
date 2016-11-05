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

namespace Kreta\TaskManager\Infrastructure\Ui\Web\Api\GraphQL\Query\Organization;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\TaskManager\Application\Query\Organization\CountOrganizationsQuery;
use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsQuery;
use Kreta\TaskManager\Infrastructure\Ui\Web\Api\GraphQL\Query\Resolver;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class OrganizationsResolver implements Resolver
{
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function resolve($args)
    {
        if (!isset($args['name'])) {
            $args['name'] = null;
        }

        list($offset, $limit, $total) = $this->buildPagination($args);

        $this->queryBus->handle(
            new FilterOrganizationsQuery(
                $offset,
                $limit,
                $args['name']
            ),
            $result
        );

        $connection = ConnectionBuilder::connectionFromArraySlice(
            $result,
            $args,
            [
                'sliceStart'  => $offset,
                'arrayLength' => $total,
            ]
        );
        $connection->totalCount = count($result);

        return $connection;
    }

    private function buildPagination($args)
    {
        $this->queryBus->handle(
            new CountOrganizationsQuery(
                $args['name']
            ),
            $total
        );

        // AL COUNT QUERY ESTE DE ARRIBA HAY QUE PASARLE EL $name y en vez de usar el size del repo hay que hacer
        // como hacemos en el CMS con el buildQuery y el buildCount

        $beforeOffset = ConnectionBuilder::getOffsetWithDefault(
            isset($args['before'])
                ? $args['before']
                : null,
            $total
        );
        $afterOffset = ConnectionBuilder::getOffsetWithDefault(
            isset($args['after'])
                ? $args['after']
                : null,
            -1
        );
        $startOffset = max($afterOffset, -1) + 1;
        $endOffset = min($beforeOffset, $total);

        if (isset($args['first']) && is_numeric($args['first'])) {
            $endOffset = min($endOffset, $startOffset + $args['first']);
        }
        if (isset($args['last']) && is_numeric($args['last'])) {
            $startOffset = max($startOffset, $endOffset - $args['last']);
        }
        $offset = max($startOffset, 0);
        $limit = $endOffset - $startOffset;

        return [
            $offset,
            $limit,
            $total,
        ];
    }
}

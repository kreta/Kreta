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

namespace Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Organization;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Relay\ConnectionBuilder;
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Organization\CountOrganizationsQuery;
use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrganizationsResolver implements Resolver
{
    private $connectionBuilder;
    private $queryBus;
    private $currentUser;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ConnectionBuilder $connectionBuilder,
        QueryBus $queryBus
    ) {
        $this->connectionBuilder = $connectionBuilder;
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
    }

    public function resolve($args)
    {
        if (!isset($args['name'])) {
            $args['name'] = null;
        }
        if (isset($args['organizationConnectionInput'])) {
            foreach ($args['organizationConnectionInput'] as $key => $value) {
                $args[$key] = $value;
            }
            unset($args['organizationConnectionInput']);
        }

        list($offset, $limit, $total) = $this->buildPagination($args);

        $this->queryBus->handle(
            new FilterOrganizationsQuery(
                $this->currentUser,
                $offset,
                $limit,
                $args['name']
            ),
            $result
        );

        $connection = $this->connectionBuilder->fromArraySlice(
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
                $this->currentUser,
                $args['name']
            ),
            $total
        );

        $beforeOffset = $this->connectionBuilder->getOffsetWithDefault(
            $args['before']
                ?? null,
            $total
        );
        $afterOffset = $this->connectionBuilder->getOffsetWithDefault(
            $args['after']
                ?? null,
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

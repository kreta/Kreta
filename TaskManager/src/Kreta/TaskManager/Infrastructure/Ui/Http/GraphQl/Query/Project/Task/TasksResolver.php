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

namespace Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Project\Task;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Relay\ConnectionBuilder;
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdQuery;
use Kreta\TaskManager\Application\Query\Project\Task\CountTasksQuery;
use Kreta\TaskManager\Application\Query\Project\Task\FilterTasksQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TasksResolver implements Resolver
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
        if (!isset($args['title'])) {
            $args['title'] = null;
        }
        if (!isset($args['projectId'])) {
            $args['projectId'] = null;
        }
        if (!isset($args['parentId'])) {
            $args['parentId'] = null;
        }
        if (!isset($args['priority'])) {
            $args['priority'] = null;
        }
        if (!isset($args['progress'])) {
            $args['progress'] = null;
        }

        list($offset, $limit, $total) = $this->buildPagination($args);

        $this->queryBus->handle(
            new FilterTasksQuery(
                $this->currentUser,
                $offset,
                $limit,
                $args['parentId'],
                $args['projectId'],
                $args['title'],
                $args['priority'],
                $args['progress']
            ),
            $result
        );

        foreach ($result as $key => $task) {
            $this->queryBus->handle(
                new ProjectOfIdQuery(
                    $task['project_id'],
                    $this->currentUser
                ),
                $result[$key]['project']
            );
            unset($result[$key]['project_id']);
        }

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
            new CountTasksQuery(
                $this->currentUser,
                $args['parentId'],
                $args['projectId'],
                $args['title'],
                $args['priority'],
                $args['progress']
            ),
            $total
        );

        $beforeOffset = $this->connectionBuilder->getOffsetWithDefault(
            isset($args['before'])
                ? $args['before']
                : null,
            $total
        );
        $afterOffset = $this->connectionBuilder->getOffsetWithDefault(
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

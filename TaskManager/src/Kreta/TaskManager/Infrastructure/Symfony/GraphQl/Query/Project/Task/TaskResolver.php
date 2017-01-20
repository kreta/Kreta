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

namespace Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project\Task;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Project\Task\TaskOfIdQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TaskResolver implements Resolver
{
    private $queryBus;
    private $currentUser;
    private $taskBuilderResolver;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        QueryBus $queryBus,
        TaskBuilderResolver $taskBuilderResolver
    ) {
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->taskBuilderResolver = $taskBuilderResolver;
    }

    public function resolve($args)
    {
        $this->queryBus->handle(
            new TaskOfIdQuery(
                $args['id'],
                $this->currentUser
            ),
            $result
        );

        $result = $this->taskBuilderResolver->resolve($result);

        return $result;
    }

    public function resolveByParent($parentId)
    {
        return null === $parentId ? null : $this->resolve(['id' => $parentId]);
    }
}

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
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Project\Task\TaskOfIdQuery;
use Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Organization\MemberResolver;
use Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Project\ProjectResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TaskResolver implements Resolver
{
    private $queryBus;
    private $currentUser;
    private $projectResolver;
    private $memberResolver;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        QueryBus $queryBus,
        TaskBuilderResolver $taskBuilderResolver,
        ProjectResolver $projectResolver,
        MemberResolver $memberResolver
    ) {
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->taskBuilderResolver = $taskBuilderResolver;
        $this->projectResolver = $projectResolver;
        $this->memberResolver = $memberResolver;
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

        $result = $this->resolveProject($result);
        $result = $this->resolveMember($result);

        return $result;
    }

    private function resolveProject(array $result) : array
    {
        $result['project'] = $this->projectResolver->resolve([
            'id' => $result['project_id'],
        ]);
        unset($result['project_id']);

        return $result;
    }

    private function resolveMember(array $result) : array
    {
        foreach (TaskBuilderResolver::MEMBER_TYPES as $memberType) {
            $result[$memberType] = $this->memberResolver->resolve([
                'organizationId'       => $result['project']['organization']['id'],
                'ownerId'              => $result[$memberType . '_id'],
                'organizationMemberId' => $result[$memberType . '_id'],
            ]);

            $result[$memberType]['organizationId'] = $result['project']['organization']['id'];
            $result[$memberType]['ownerId'] = $result[$memberType . '_id'];
            $result[$memberType]['organizationMemberId'] = $result[$memberType . '_id'];
            unset($result[$memberType . '_id']);
        }

        return $result;
    }
}

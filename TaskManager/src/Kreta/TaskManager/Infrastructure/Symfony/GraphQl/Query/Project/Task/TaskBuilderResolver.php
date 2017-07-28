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

use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Organization\MemberResolver;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project\ProjectResolver;

class TaskBuilderResolver implements Resolver
{
    const MEMBER_TYPES = ['assignee', 'reporter'];

    private $memberResolver;
    private $projectResolver;

    public function __construct(ProjectResolver $projectResolver, MemberResolver $memberResolver)
    {
        $this->memberResolver = $memberResolver;
        $this->projectResolver = $projectResolver;
    }

    public function resolve($task)
    {
        $task['project'] = $this->projectResolver->resolve([
            'id' => $task['project_id'],
        ]);
        unset($task['project_id']);

        foreach (self::MEMBER_TYPES as $memberType) {
            $task[$memberType] = $this->memberResolver->resolve([
                'organizationId'       => $task['project']['organization']['id'],
                'ownerId'              => $task[$memberType . '_id'],
                'organizationMemberId' => $task[$memberType . '_id'],
            ]);

            $task[$memberType]['organizationId'] = $task['project']['organization']['id'];
            $task[$memberType]['ownerId'] = $task[$memberType . '_id'];
            $task[$memberType]['organizationMemberId'] = $task[$memberType . '_id'];
            unset($task[$memberType . '_id']);
        }

        return $task;
    }
}

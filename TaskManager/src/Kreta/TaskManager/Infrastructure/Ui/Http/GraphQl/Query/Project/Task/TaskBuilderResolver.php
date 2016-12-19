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

use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Organization\MemberResolver;
use Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Project\ProjectResolver;

class TaskBuilderResolver implements Resolver
{
    const MEMBER_TYPES = ['assignee', 'creator'];

    private $memberResolver;
    private $projectResolver;

    public function __construct(ProjectResolver $projectResolver, MemberResolver $memberResolver)
    {
        $this->memberResolver = $memberResolver;
        $this->projectResolver = $projectResolver;
    }

    public function resolve($args)
    {
        $result = $args['task'];
//        var_dump($result);die;

        $result['project'] = $this->projectResolver->resolve([
            'id' => $result['project_id'],
        ]);
        unset($result['project_id']);

        foreach (self::MEMBER_TYPES as $memberType) {
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

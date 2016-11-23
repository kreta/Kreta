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

namespace Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Organization;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Organization\OrganizationMemberOfIdQuery;
use Kreta\TaskManager\Application\Query\Organization\OwnerOfIdQuery;

class MemberTypeResolver implements Resolver
{
    private $resolver;
    private $queryBus;

    public function __construct(Resolver $resolver, QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        $this->resolver = $resolver;
    }

    public function resolve($args)
    {
        $this->queryBus->handle(
            new OwnerOfIdQuery(
                $args['organizationId'],
                $args['userId']
            ),
            $result
        );
        if (isset($result['id'])) {
            return $this->resolver->resolve('Owner');
        }
        $this->queryBus->handle(
            new OrganizationMemberOfIdQuery(
                $args['organizationId'],
                $args['userId']
            ),
            $result
        );
        if (isset($result['id'])) {
            return $this->resolver->resolve('OrganizationMember');
        }
    }
}

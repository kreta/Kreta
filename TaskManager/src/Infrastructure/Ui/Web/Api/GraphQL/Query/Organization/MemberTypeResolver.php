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
use Kreta\TaskManager\Application\Query\Organization\OrganizationMemberOfIdQuery;
use Kreta\TaskManager\Application\Query\Organization\OwnerOfIdQuery;
use Kreta\TaskManager\Infrastructure\Ui\Web\Api\GraphQL\Query\Resolver;
use Overblog\GraphQLBundle\Resolver\TypeResolver;

class MemberTypeResolver implements Resolver
{
    private $typeResolver;
    private $queryBus;

    public function __construct(TypeResolver $typeResolver, QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        $this->typeResolver = $typeResolver;
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
            return $this->typeResolver->resolve('Owner');
        }
        $this->queryBus->handle(
            new OrganizationMemberOfIdQuery(
                $args['organizationId'],
                $args['userId']
            ),
            $result
        );
        if (isset($result['id'])) {
            return $this->typeResolver->resolve('OrganizationMember');
        }
    }
}

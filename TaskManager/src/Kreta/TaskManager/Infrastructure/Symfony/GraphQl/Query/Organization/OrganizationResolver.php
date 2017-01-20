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
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfIdQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrganizationResolver implements Resolver
{
    private $queryBus;
    private $currentUser;

    public function __construct(TokenStorageInterface $tokenStorage, QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
    }

    public function resolve($args)
    {
        $this->queryBus->handle(
            new OrganizationOfIdQuery(
                $args['id'],
                $this->currentUser
            ),
            $result
        );

        return $result;
    }
}

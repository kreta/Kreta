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

namespace Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Project;

use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Resolver;
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdQuery;
use Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Organization\OrganizationResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProjectResolver implements Resolver
{
    private $queryBus;
    private $currentUser;
    private $organizationResolver;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        QueryBus $queryBus,
        OrganizationResolver $organizationResolver
    ) {
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->organizationResolver = $organizationResolver;
    }

    public function resolve($args)
    {
        $this->queryBus->handle(
            new ProjectOfIdQuery(
                $args['id'],
                $this->currentUser
            ),
            $result
        );

        $result['organization'] = $this->organizationResolver->resolve([
            'id' => $result['organization_id'],
        ]);
        unset($result['organization_id']);

        return $result;
    }
}

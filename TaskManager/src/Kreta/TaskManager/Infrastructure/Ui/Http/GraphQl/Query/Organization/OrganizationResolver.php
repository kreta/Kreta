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
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfIdQuery;
use Kreta\TaskManager\Infrastructure\Ui\Http\GraphQl\Query\Project\ProjectsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrganizationResolver implements Resolver
{
    private $queryBus;
    private $currentUser;
    private $projectsResolver;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        QueryBus $queryBus,
        ProjectsResolver $projectsResolver
    )
    {
        $this->queryBus = $queryBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->projectsResolver = $projectsResolver;
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
        $result['projects'] = $this->projectsResolver->resolve([
            'organizationId' => $args['id']
        ]);

        return $result;
    }
}

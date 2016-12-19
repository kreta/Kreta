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
use Kreta\TaskManager\Domain\Model\Organization\OwnerDoesNotExistException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MemberResolver implements Resolver
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
        try {
            $this->queryBus->handle(
                new OwnerOfIdQuery(
                    $args['organizationId'],
                    $args['ownerId'],
                    $this->currentUser
                ),
                $result
            );
        } catch (OwnerDoesNotExistException $exception) {
        }

        if (empty($result)) {
            $this->queryBus->handle(
                new OrganizationMemberOfIdQuery(
                    $args['organizationId'],
                    $args['organizationMemberId'],
                    $this->currentUser
                ),
                $result
            );
        }

        $result['organization'] = $this->organizationResolver->resolve([
            'id' => $args['organizationId'],
        ]);

        return $result;
    }
}

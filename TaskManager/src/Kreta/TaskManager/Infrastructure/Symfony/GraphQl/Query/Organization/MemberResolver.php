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
use Kreta\TaskManager\Application\Query\Organization\OrganizationMemberOfIdQuery;
use Kreta\TaskManager\Application\Query\Organization\OwnerOfIdQuery;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OwnerDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Overblog\GraphQLBundle\Error\UserError;
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
        if (isset($args['ownerId'])) {
            $result = $this->owner(
                $args['organizationId'],
                $args['ownerId']
            );
        } else {
            $result = $this->organizationMember(
                $args['organizationId'],
                $args['organizationMemberId']
            );
        }
        $result['organization'] = $this->organizationResolver->resolve([
            'id' => $args['organizationId'],
        ]);

        return $result;
    }

    private function owner($organizationId, $ownerId)
    {
        try {
            $this->queryBus->handle(
                new OwnerOfIdQuery(
                    $organizationId,
                    $ownerId,
                    $this->currentUser
                ),
                $result
            );

            return $result;
        } catch (OrganizationDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does no exist any organization with the given "%s" id',
                    $organizationId
                )
            );
        } catch (UnauthorizedOrganizationActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to access the "%s" organization',
                    $this->currentUser,
                    $organizationId
                )
            );
        } catch (OwnerDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does no exist any owner with the given "%s" id',
                    $ownerId
                )
            );
        }
    }

    private function organizationMember($organizationId, $organizationMemberId)
    {
        try {
            $this->queryBus->handle(
                new OrganizationMemberOfIdQuery(
                    $organizationId,
                    $organizationMemberId,
                    $this->currentUser
                ),
                $result
            );

            return $result;
        } catch (OrganizationDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does no exist any organization with the given "%s" id',
                    $organizationId
                )
            );
        } catch (UnauthorizedOrganizationActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to access the "%s" organization',
                    $this->currentUser,
                    $organizationId
                )
            );
        } catch (OrganizationMemberDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does no exist any organization member with the given "%s" id',
                    $organizationMemberId
                )
            );
        }
    }
}

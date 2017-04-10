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
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrganizationMemberResolver implements Resolver
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
        try {
            $this->queryBus->handle(
                new OrganizationMemberOfIdQuery(
                    $args['organizationId'],
                    $args['organizationMemberId'],
                    $this->currentUser
                ),
                $result
            );

            return $result;
        } catch (OrganizationDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does not exist any organization with the given "%s" id',
                    $args['organizationId']
                )
            );
        } catch (UnauthorizedOrganizationActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to access the "%s" organization',
                    $this->currentUser,
                    $args['organizationId']
                )
            );
        } catch (OrganizationMemberDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'Does not exist any organization member with the given "%s" id',
                    $args['organizationMemberId']
                )
            );
        }
    }
}

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

namespace Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Mutation\Organization;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Http\GraphQl\Relay\Mutation;
use Kreta\TaskManager\Application\Command\Organization\RemoveOrganizationMemberToOrganizationCommand;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\User\UserDoesNotExistException;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Organization\OrganizationResolver;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RemoveMemberToOrganizationMutation implements Mutation
{
    private $commandBus;
    private $currentUser;
    private $organizationResolver;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        CommandBus $commandBus,
        OrganizationResolver $organizationResolver
    ) {
        $this->commandBus = $commandBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->organizationResolver = $organizationResolver;
    }

    public function execute(array $values) : array
    {
        $command = new RemoveOrganizationMemberToOrganizationCommand(
            $values['userId'],
            $values['organizationId'],
            $this->currentUser
        );

        try {
            $this->commandBus->handle($command);
        } catch (OrganizationDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'The organization with "%s" id does not exist',
                    $values['organizationId']
                )
            );
        } catch (UnauthorizedOrganizationActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to edit the organization',
                    $this->currentUser
                )
            );
        } catch (UserDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'The user with "%s" id does not exist',
                    $values['userId']
                )
            );
        }

        $organization = $this->organizationResolver->resolve([
            'id' => $values['organizationId'],
        ]);

        return [
            'organization' => $organization,
        ];
    }
}

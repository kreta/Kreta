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
use Kreta\TaskManager\Application\Command\Organization\EditOrganizationCommand;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedEditOrganizationException;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Organization\OrganizationResolver;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditOrganizationMutation implements Mutation
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
        $command = new EditOrganizationCommand(
            $values['id'],
            $values['name'],
            $this->currentUser
        );

        try {
            $this->commandBus->handle($command);
        } catch (OrganizationAlreadyExistsException $exception) {
            throw new UserError(
                sprintf(
                    'The organization with "%s" name already exists',
                    $values['name']
                )
            );
        } catch (OrganizationDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'The organization with "%s" id does not exist',
                    $values['id']
                )
            );
        } catch (UnauthorizedEditOrganizationException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to edit the organization',
                    $this->currentUser
                )
            );
        }

        $organization = $this->organizationResolver->resolve([
            'id' => $command->id(),
        ]);

        return [
            'organization' => $organization,
        ];
    }
}

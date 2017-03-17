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

namespace Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Mutation\Project;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Http\GraphQl\Relay\Mutation;
use Kreta\TaskManager\Application\Command\Project\CreateProjectCommand;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectAlreadyExists;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedCreateProjectException;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project\ProjectResolver;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateProjectMutation implements Mutation
{
    private $commandBus;
    private $currentUser;
    private $projectResolver;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        CommandBus $commandBus,
        ProjectResolver $projectResolver
    ) {
        $this->commandBus = $commandBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->projectResolver = $projectResolver;
    }

    public function execute(array $values) : array
    {
        $command = new CreateProjectCommand(
            $values['name'],
            $values['organizationId'],
            $this->currentUser,
            null,
            $values['slug'] ?? null
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
        } catch (ProjectAlreadyExists $exception) {
            throw new UserError(
                sprintf(
                    'The project with "%s" name already exists in the organization with %s id',
                    $values['name'],
                    $values['organizationId']
                )
            );
        } catch (UnauthorizedCreateProjectException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to create the project',
                    $this->currentUser
                )
            );
        }

        $project = $this->projectResolver->resolve([
            'id' => $command->id(),
        ]);

        return [
            'project' => $project,
        ];
    }
}

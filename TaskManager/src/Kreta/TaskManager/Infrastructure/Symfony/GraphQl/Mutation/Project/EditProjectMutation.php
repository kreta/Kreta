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
use Kreta\TaskManager\Application\Command\Project\EditProjectCommand;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectActionException;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project\ProjectResolver;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditProjectMutation implements Mutation
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
        $command = new EditProjectCommand(
            $values['id'],
            $values['name'],
            $this->currentUser,
            $values['slug'] ?? null
        );

        try {
            $this->commandBus->handle($command);
        } catch (ProjectDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'The project with "%s" id does not exist',
                    $values['id']
                )
            );
        } catch (UnauthorizedProjectActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to edit the project',
                    $this->currentUser
                )
            );
        }

        $project = $this->projectResolver->resolve([
            'id' => $values['id'],
        ]);

        return [
            'project' => $project,
        ];
    }
}

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

namespace Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Mutation\Project\Task;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Http\GraphQl\Relay\Mutation;
use Kreta\TaskManager\Application\Command\Project\Task\ChangeTaskProgressCommand;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project\Task\TaskResolver;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ChangeTaskProgressMutation implements Mutation
{
    private $commandBus;
    private $currentUser;
    private $taskResolver;

    public function __construct(TokenStorageInterface $tokenStorage, CommandBus $commandBus, TaskResolver $taskResolver)
    {
        $this->commandBus = $commandBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
        $this->taskResolver = $taskResolver;
    }

    public function execute(array $values) : array
    {
        $changeTaskProgressCommand = new ChangeTaskProgressCommand(
            $values['id'],
            $values['progress'],
            $this->currentUser
        );

        try {
            $this->commandBus->handle($changeTaskProgressCommand);
        } catch (TaskDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'The task with "%s" id does not exist',
                    $values['id']
                )
            );
        } catch (UnauthorizedTaskActionException $exception) {
            throw new UserError(
                sprintf(
                    'The "%s" user does not allow to change the progress of the task',
                    $this->currentUser
                )
            );
        }

        $task = $this->taskResolver->resolve([
            'id' => $changeTaskProgressCommand->id(),
        ]);

        return [
            'task' => $task,
        ];
    }
}

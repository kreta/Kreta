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
use Kreta\TaskManager\Application\Command\Project\Task\CreateTaskCommand;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project\Task\TaskResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateTaskMutation implements Mutation
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
        $command = new CreateTaskCommand(
            $values['title'],
            $values['description'],
            $this->currentUser,
            $values['assigneeId'],
            $values['priority'],
            $values['projectId'],
            $values['parentId'] ?? null
        );

        $this->commandBus->handle($command);

        return [
            'task' => $this->taskResolver->resolve([
                'id' => $command->taskId(),
            ]),
        ];
    }
}

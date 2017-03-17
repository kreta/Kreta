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
use Kreta\TaskManager\Application\Command\Project\Task\ChangeParentTaskCommand;
use Kreta\TaskManager\Application\Command\Project\Task\ChangeTaskPriorityCommand;
use Kreta\TaskManager\Application\Command\Project\Task\EditTaskCommand;
use Kreta\TaskManager\Application\Command\Project\Task\ReassignTaskCommand;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskAndTaskParentCannotBeTheSameException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentCannotBelongToOtherProjectException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Infrastructure\Symfony\GraphQl\Query\Project\Task\TaskResolver;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditTaskMutation implements Mutation
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
        $editTaskCommand = new EditTaskCommand(
            $values['id'],
            $values['title'],
            $values['description'],
            $this->currentUser
        );
        $changePriorityCommand = new ChangeTaskPriorityCommand(
            $values['id'],
            $values['priority'],
            $this->currentUser
        );
        $reassignTaskCommand = new ReassignTaskCommand(
            $values['id'],
            $values['assigneeId'],
            $this->currentUser
        );
        $changeParentTaskCommand = new ChangeParentTaskCommand(
            $values['id'],
            $this->currentUser,
            $values['parentId'] ?? null
        );

        try {
            $this->commandBus->handle($editTaskCommand);
            $this->commandBus->handle($changePriorityCommand);
            $this->commandBus->handle($reassignTaskCommand);
            $this->commandBus->handle($changeParentTaskCommand);
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
                    'The "%s" user does not allow to edit the task',
                    $this->currentUser
                )
            );
        } catch (TaskAndTaskParentCannotBeTheSameException $exception) {
            throw new UserError('The task and its parent are the same');
        } catch (TaskParentDoesNotExistException $exception) {
            throw new UserError(
                sprintf(
                    'The task parent with "%s" id does not exist',
                    $values['parentId']
                )
            );
        } catch (TaskParentCannotBelongToOtherProjectException $exception) {
            throw new UserError(
                sprintf(
                    'The task parent with "%s" id does not belong to the task\'s project',
                    $values['parentId']
                )
            );
        }

        $task = $this->taskResolver->resolve([
            'id' => $editTaskCommand->id(),
        ]);

        return [
            'task' => $task,
        ];
    }
}

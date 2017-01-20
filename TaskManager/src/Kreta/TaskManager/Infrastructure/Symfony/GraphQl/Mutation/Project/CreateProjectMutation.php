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
use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Http\GraphQl\Relay\Mutation;
use Kreta\TaskManager\Application\Command\Project\CreateProjectCommand;
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateProjectMutation implements Mutation
{
    private $commandBus;
    private $queryBus;
    private $currentUser;

    public function __construct(TokenStorageInterface $tokenStorage, CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->currentUser = $tokenStorage->getToken()->getUser()->getUsername();
    }

    public function execute(array $values) : array
    {
        $command = new CreateProjectCommand(
            $values['name'],
            $values['organizationId'],
            $this->currentUser,
            null,
            isset($values['slug']) ? $values['slug'] : null
        );

        $this->commandBus->handle($command);

        $this->queryBus->handle(
            new ProjectOfIdQuery(
                $command->id(),
                $this->currentUser
            ),
            $project
        );

        return [
            'project' => $project,
        ];
    }
}

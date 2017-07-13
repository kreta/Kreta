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

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\DataFixtures\AbstractFixture;
use Kreta\TaskManager\Application\Command\Project\Task\CreateTaskCommand;
use Kreta\TaskManager\Application\Query\Organization\OrganizationOfIdQuery;
use Kreta\TaskManager\Application\Query\Project\FilterProjectsQuery;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;

class LoadTaskData extends AbstractFixture
{
    const TASK_PRIORITIES = [TaskPriority::LOW, TaskPriority::MEDIUM, TaskPriority::HIGH];

    protected function type() : string
    {
        return 'task';
    }

    public function getOrder() : int
    {
        return 4;
    }

    public function load(ObjectManager $manager) : void
    {
        $i = 0;
        while ($i < $this->amount()) {
            $userId = $this->getRandomUserByIndex($i);

            $this->queryBus()->handle(
                new FilterProjectsQuery(
                    $userId,
                    0,
                    1
                ),
                $projects
            );

            foreach ($projects as $project) {
                $this->queryBus()->handle(
                    new OrganizationOfIdQuery(
                        $project['organization_id'],
                        $userId
                    ),
                    $organization
                );

                $parent = 40 === $i || 70 === $i ? $this->fakeIds()[10] : null;

                $this->commandBus()->handle(
                    new CreateTaskCommand(
                        'Task ' . $i,
                        'The description of the task ' . $i,
                        $userId,
                        $organization['owners'][0]['id'],
                        $this->taskPriority($i),
                        $project['id'],
                        $parent,
                        $this->fakeIds()[$i]
                    )
                );
                ++$i;
            }
        }
    }

    private function taskPriority($index)
    {
        $priorityIndex = $index % 2 > 3 ? 0 : 2 - $index % 3;

        return self::TASK_PRIORITIES[$priorityIndex];
    }
}

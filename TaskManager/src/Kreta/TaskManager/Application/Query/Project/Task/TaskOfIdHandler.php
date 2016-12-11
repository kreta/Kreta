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

namespace Kreta\TaskManager\Application\Query\Project\Task;

use Kreta\TaskManager\Application\DataTransformer\Project\Task\TaskDataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class TaskOfIdHandler
{
    private $repository;
    private $projectRepository;
    private $organizationRepository;
    private $dataTransformer;

    public function __construct(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $repository,
        TaskDataTransformer $dataTransformer
    ) {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
        $this->organizationRepository = $organizationRepository;
        $this->projectRepository = $projectRepository;
    }

    public function __invoke(TaskOfIdQuery $query)
    {
        $task = $this->repository->taskOfId(
            TaskId::generate(
                $query->taskId()
            )
        );
        if (!$task instanceof Task) {
            throw new TaskDoesNotExistException();
        }
        $project = $this->projectRepository->projectOfId(
            $task->projectId()
        );
        $organization = $this->organizationRepository->organizationOfId(
            $project->organizationId()
        );
        if (!$organization->isOrganizationMember(UserId::generate($query->userId()))) {
            throw new UnauthorizedTaskResourceException();
        }

        $this->dataTransformer->write($task);

        return $this->dataTransformer->read();
    }
}

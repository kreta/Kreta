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

namespace Kreta\TaskManager\Application\Command\Project\Task;

use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskAndTaskParentCannotBeTheSameException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CreateTaskHandler
{
    private $repository;
    private $projectRepository;
    private $organizationRepository;

    public function __construct(
        TaskRepository $repository,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository
    ) {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function __invoke(CreateTaskCommand $command)
    {
        if (null !== $id = $command->taskId()) {
            $task = $this->repository->taskOfId(
                TaskId::generate(
                    $id
                )
            );
            if ($command->parentId() === $command->taskId()) {
                throw new TaskAndTaskParentCannotBeTheSameException();
            }
            if ($task instanceof Task) {
                throw new TaskAlreadyExistsException();
            }
        }
        $project = $this->projectRepository->projectOfId(
            ProjectId::generate(
                $command->projectId()
            )
        );
        if (!$project instanceof Project) {
            throw new ProjectDoesNotExistException();
        }
        $organization = $this->organizationRepository->organizationOfId(
            $project->organizationId()
        );
        $creatorId = UserId::generate($command->creatorId());
        $assigneeId = UserId::generate($command->assigneeId());
        if (!$organization->isOrganizationMember($creatorId) || !$organization->isOrganizationMember($assigneeId)) {
            throw new UnauthorizedTaskActionException();
        }
        if (null !== $parentId = $command->parentId()) {
            $parent = $this->repository->taskOfId(
                TaskId::generate(
                    $parentId
                )
            );
            if (!$parent instanceof Task) {
                throw new TaskParentDoesNotExistException();
            }
        }
        $task = new Task(
            TaskId::generate($id),
            new TaskTitle(
                $command->title()
            ),
            $command->description(),
            $organization->organizationMember($creatorId)->id(),
            $organization->organizationMember($assigneeId)->id(),
            new TaskPriority($command->priority()),
            $project->id(),
            null === $parentId ? null : TaskId::generate($parentId)
        );
        $this->repository->persist($task);
    }
}

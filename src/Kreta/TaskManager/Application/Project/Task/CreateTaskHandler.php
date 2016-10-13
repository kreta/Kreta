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

declare(strict_types = 1);

namespace Kreta\TaskManager\Application\Project\Task;

use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
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
    )
    {
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
        $creatorId = OwnerId::generate(UserId::generate($command->creatorUserId()), $command->creatorMemberId();
        $assigneeId = OwnerId::generate(UserId::generate($command->assigneeUserId()), $command->creatorMemberId();
        if (!$organization->isMember($creatorId) || !$organization->isMember($assigneeId)) {
            throw new UnauthorizedCreateTaskException();
        }
        if (null !== $parentId = $command->parentId()) {
            $parent = $this->repository->taskOfId(
                TaskId::generate(
                    $parentId
                )
            );
            if (!$parent instanceof Task) {
                throw new TaskDoesNotExistException();
            }
        }
        $task = new Task(
            TaskId::generate($id),
            new TaskTitle(
                $command->title()
            ),
            $command->description(),
            $creatorId,
            $assigneeId,
            new TaskPriority($command->priority()),
            $project->id(),
            $parentId
        );
        $this->repository->persist($task);
    }
}

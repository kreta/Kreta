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

namespace Kreta\TaskManager\Application\Project\Task;

use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskAndTaskParentCannotBeTheSameException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentCannotBelongToOtherProjectException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class ChangeParentTaskHandler
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

    public function __invoke(ChangeParentTaskCommand $command)
    {
        $task = $this->repository->taskOfId(
            TaskId::generate(
                $command->id()
            )
        );
        if (!$task instanceof Task) {
            throw new TaskDoesNotExistException();
        }

        if (null !== $parentId = $command->parentId()) {
            if ($parentId === $task->id()->id()) {
                throw new TaskAndTaskParentCannotBeTheSameException();
            }
            $parent = $this->repository->taskOfId(
                TaskId::generate(
                    $parentId
                )
            );
            if (!$parent instanceof Task) {
                throw new TaskParentDoesNotExistException();
            }
            if (!$task->projectId()->equals($parent->projectId())) {
                throw new TaskParentCannotBelongToOtherProjectException();
            }
        }

        $project = $this->projectRepository->projectOfId(
            $task->projectId()
        );
        $organization = $this->organizationRepository->organizationOfId(
            $project->organizationId()
        );
        $changerId = MemberId::generate(
            UserId::generate(
                $command->changerId()
            ),
            $organization->id()
        );

        if (!$organization->isMember($changerId)) {
            throw new UnauthorizedTaskActionException();
        }

        $task->changeParent(
            !isset($parent) ? null : $parent->id()
        );

        $this->repository->persist($task);
    }
}

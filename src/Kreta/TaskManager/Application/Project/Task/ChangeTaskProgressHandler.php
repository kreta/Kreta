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
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class ChangeTaskProgressHandler
{
    private $organizationRepository;
    private $projectRepository;
    private $taskRepository;

    public function __construct(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository
    ) {
        $this->organizationRepository = $organizationRepository;
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(ChangeTaskProgressCommand $command)
    {
        $task = $this->taskRepository->taskOfId(TaskId::generate($command->id()));
        if (!$task instanceof Task) {
            throw new TaskDoesNotExistException();
        }

        $project = $this->projectRepository->projectOfId($task->projectId());
        if (!$project instanceof Project) {
            throw new ProjectDoesNotExistException();
        }

        $organization = $this->organizationRepository->organizationOfId($project->organizationId());
        if (!$organization instanceof Organization) {
            throw new OrganizationDoesNotExistException();
        }

        if (!$organization->isMember(MemberId::generate(UserId::generate($command->editorId()), $organization->id()))) {
            throw new UnauthorizedTaskActionException();
        }

        $task->changeProgress(new TaskProgress($command->progress()));

        $this->taskRepository->persist($task);
    }
}

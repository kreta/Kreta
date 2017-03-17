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
        $taskId = TaskId::generate($command->id());
        $editorId = UserId::generate($command->editorId());
        $progress = new TaskProgress($command->progress());

        $task = $this->taskRepository->taskOfId($taskId);
        $this->checkTaskExists($task);
        $this->checkEditorPrivileges($task, $editorId);
        $task->changeProgress($progress);

        $this->taskRepository->persist($task);
    }

    private function checkTaskExists(Task $task = null) : void
    {
        if (!$task instanceof Task) {
            throw new TaskDoesNotExistException();
        }
    }

    private function checkEditorPrivileges(Task $task, UserId $editorId) : void
    {
        $project = $this->projectRepository->projectOfId($task->projectId());
        $organization = $this->organizationRepository->organizationOfId($project->organizationId());
        if (!$organization->isOrganizationMember($editorId)) {
            throw new UnauthorizedTaskActionException();
        }
    }
}

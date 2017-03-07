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

use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\NumericId;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskAndTaskParentCannotBeTheSameException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskParentDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CreateTaskHandler
{
    private $repository;
    private $specificationFactory;
    private $projectRepository;
    private $organizationRepository;

    public function __construct(
        TaskRepository $repository,
        TaskSpecificationFactory $specificationFactory,
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->projectRepository = $projectRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function __invoke(CreateTaskCommand $command)
    {
        $taskId = $command->taskId();
        $parentTaskId = $command->parentId();

        if (!$this->areTaskAndParentIdsDifferent($taskId, $parentTaskId)) {
            throw new TaskAndTaskParentCannotBeTheSameException();
        }

        $task = $this->repository->taskOfId(TaskId::generate($taskId));
        if ($this->doesTaskExist($task)) {
            throw new TaskAlreadyExistsException();
        }

        $parentTask = $this->repository->taskOfId(TaskId::generate($parentTaskId));
        if (!$this->doesParentTaskExist($parentTaskId, $parentTask)) {
            throw new TaskParentDoesNotExistException();
        }

        $projectId = $command->projectId();
        $project = $this->projectRepository->projectOfId(ProjectId::generate($projectId));
        if (!$this->doesProjectExist($project)) {
            throw new ProjectDoesNotExistException();
        }

        $organizationId = $project->organizationId();
        $creatorId = UserId::generate($command->creatorId());
        $assigneeId = UserId::generate($command->assigneeId());

        $organization = $this->organizationRepository->organizationOfId($organizationId);
        if (!$this->areUsersOrganizationMembers($organization, $creatorId, $assigneeId)) {
            throw new UnauthorizedTaskActionException();
        }

        $taskId = TaskId::generate($taskId);
        $title = new TaskTitle($command->title());
        $description = $command->description();
        $creator = $this->becomeUserIdToDomainMemberId($organization, $creatorId);
        $assignee = $this->becomeUserIdToDomainMemberId($organization, $assigneeId);
        $priority = new TaskPriority($command->priority());
        $projectId = ProjectId::generate($projectId);
        $parentTaskId = $this->parentTaskId($parentTaskId);

        $tasksNumber = $this->repository->count(
            $this->specificationFactory->buildByProjectSpecification($projectId)
        );
        $numericId = NumericId::fromPrevious($tasksNumber);

        $task = new Task(
            $taskId,
            $numericId,
            $title,
            $description,
            $creator,
            $assignee,
            $priority,
            $projectId,
            $parentTaskId
        );
        $this->repository->persist($task);
    }

    private function areTaskAndParentIdsDifferent($taskId, $parentTaskId) : bool
    {
        return ($taskId === null && $parentTaskId === null) || $parentTaskId !== $taskId;
    }

    private function doesTaskExist(Task $task = null) : bool
    {
        return $task instanceof Task;
    }

    private function doesParentTaskExist($parentTaskId, Task $parentTask = null) : bool
    {
        return null === $parentTaskId || $parentTask instanceof Task;
    }

    private function doesProjectExist(Project $project = null) : bool
    {
        return $project instanceof Project;
    }

    private function areUsersOrganizationMembers(Organization $organization, UserId $creatorId, UserId $assigneeId)
    {
        return $organization->isOrganizationMember($creatorId)
            && $organization->isOrganizationMember($assigneeId);
    }

    private function parentTaskId($parentTaskId)
    {
        return null === $parentTaskId ? null : TaskId::generate($parentTaskId);
    }

    private function becomeUserIdToDomainMemberId(Organization $organization, UserId $userId) : MemberId
    {
        return $organization->organizationMember($userId)->id();
    }
}

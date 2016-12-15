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
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class FilterTasksHandler
{
    private $repository;
    private $specificationFactory;
    private $dataTransformer;
    private $projectRepository;
    private $projectSpecificationFactory;
    private $organizationRepository;
    private $organizationSpecificationFactory;

    public function __construct(
        OrganizationRepository $organizationRepository,
        OrganizationSpecificationFactory $organizationSpecificationFactory,
        ProjectRepository $projectRepository,
        ProjectSpecificationFactory $projectSpecificationFactory,
        TaskRepository $repository,
        TaskSpecificationFactory $specificationFactory,
        TaskDataTransformer $dataTransformer
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->dataTransformer = $dataTransformer;
        $this->organizationRepository = $organizationRepository;
        $this->organizationSpecificationFactory = $organizationSpecificationFactory;
        $this->projectRepository = $projectRepository;
        $this->projectSpecificationFactory = $projectSpecificationFactory;
    }

    public function __invoke(FilterTasksQuery $query)
    {
        $userId = UserId::generate($query->userId());
        $projectIds = [ProjectId::generate($query->projectId())];
        $assigneeIds = [];
        $creatorIds = [];

        $project = $this->projectRepository->projectOfId($projectIds[0]);
        if ($project instanceof Project) {
            $organization = $this->organizationRepository->organizationOfId(
                $project->organizationId()
            );
            $assigneeIds[] = $organization->organizationMember(UserId::generate($query->assigneeId()));
            $creatorIds[] = $organization->organizationMember(UserId::generate($query->creatorId()));

            if (!$organization->isOrganizationMember($userId)) {
                throw new UnauthorizedTaskResourceException();
            }
        } else {
            $organizations = $this->organizationRepository->query(
                $this->organizationSpecificationFactory->buildFilterableSpecification(
                    null,
                    $userId
                )
            );
            $organizationIds = array_map(function (Organization $organization) use ($query) {
                $assigneeIds[] = $organization->organizationMember(UserId::generate($query->assigneeId()));
                $creatorIds[] = $organization->organizationMember(UserId::generate($query->creatorId()));

                return $organization->id();
            }, $organizations);
            $projects = $this->projectRepository->query(
                $this->projectSpecificationFactory->buildFilterableSpecification(
                    $organizationIds,
                    null
                )
            );
            $projectIds = array_map(function (Project $project) {
                return $project->id();
            }, $projects);
        }
        if (empty($projectIds)) {
            return [];
        }

        $tasks = $this->repository->query(
            $this->specificationFactory->buildFilterableSpecification(
                $projectIds,
                $query->title(),
                $this->parentTask($query->parentId(), $userId),
                null === $query->priority() ? null : new TaskPriority($query->priority()),
                null === $query->progress() ? null : new TaskProgress($query->progress()),
                $assigneeIds,
                $creatorIds,
                $query->offset(),
                $query->limit()
            )
        );

        return array_map(function (Task $task) {
            $this->dataTransformer->write($task);

            return $this->dataTransformer->read();
        }, $tasks);
    }

    private function parentTask(? string $parentId, UserId $userId) : ? TaskId
    {
        if (null === $parentId) {
            return null;
        }

        $parent = $this->repository->taskOfId(
            TaskId::generate($parentId)
        );
        if (null === $parent) {
            return TaskId::generate();
        }

        $project = $this->projectRepository->projectOfId(
            $parent->projectId()
        );
        $organization = $this->organizationRepository->organizationOfId(
            $project->organizationId()
        );
        if (!$organization->isOrganizationMember($userId)) {
            throw new UnauthorizedTaskResourceException();
        }

        return $parent->id();
    }
}

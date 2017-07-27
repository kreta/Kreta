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

use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CountTasksHandler
{
    private $repository;
    private $specificationFactory;
    private $organizationRepository;
    private $organizationSpecificationFactory;
    private $projectRepository;
    private $projectSpecificationFactory;

    public function __construct(
        ProjectRepository $projectRepository,
        ProjectSpecificationFactory $projectSpecificationFactory,
        OrganizationRepository $organizationRepository,
        OrganizationSpecificationFactory $organizationSpecificationFactory,
        TaskRepository $repository,
        TaskSpecificationFactory $specificationFactory
    ) {
        $this->projectRepository = $projectRepository;
        $this->projectSpecificationFactory = $projectSpecificationFactory;
        $this->organizationRepository = $organizationRepository;
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->organizationSpecificationFactory = $organizationSpecificationFactory;
    }

    public function __invoke(CountTasksQuery $query) : int
    {
        $userId = UserId::generate($query->userId());
        $projectIds = [ProjectId::generate($query->projectId())];
        $assigneeIds = [];
        $reporterIds = [];

        $project = $this->projectRepository->projectOfId($projectIds[0]);
        if ($project instanceof Project) {
            $organization = $this->organizationRepository->organizationOfId(
                $project->organizationId()
            );
            $assigneeIds = $this->addUserId($assigneeIds, $organization, $query->assigneeId());
            $reporterIds = $this->addUserId($reporterIds, $organization, $query->reporterId());

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
            $organizationIds = [];
            foreach ($organizations as $organization) {
                $assigneeIds = $this->addUserId($assigneeIds, $organization, $query->assigneeId());
                $reporterIds = $this->addUserId($reporterIds, $organization, $query->reporterId());

                $organizationIds[] = $organization->id();
            }
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
            return 0;
        }

        return $this->repository->count(
            $this->specificationFactory->buildFilterableSpecification(
                $projectIds,
                $query->title(),
                $this->parentTask($query->parentId(), $userId),
                null === $query->priority() ? null : new TaskPriority($query->priority()),
                null === $query->progress() ? null : new TaskProgress($query->progress()),
                $assigneeIds,
                $reporterIds
            )
        );
    }

    private function addUserId($userIds, Organization $organization, ? string $userId)
    {
        if (null !== $userId) {
            $userIds[] = $organization->organizationMember(UserId::generate($userId));
        }

        return $userIds;
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

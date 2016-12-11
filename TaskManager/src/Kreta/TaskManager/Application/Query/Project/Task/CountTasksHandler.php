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

use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CountTasksHandler
{
    private $repository;
    private $specificationFactory;
    private $projectRepository;
    private $projectSpecificationFactory;

    public function __construct(
        ProjectRepository $projectRepository,
        ProjectSpecificationFactory $projectSpecificationFactory,
        OrganizationRepository $organizationRepository,
        TaskRepository $repository,
        TaskSpecificationFactory $specificationFactory
    ) {
        $this->projectRepository = $projectRepository;
        $this->projectSpecificationFactory = $projectSpecificationFactory;
        $this->organizationRepository = $organizationRepository;
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
    }

    public function __invoke(CountTasksQuery $query): int
    {
        $projectIds = [ProjectId::generate($query->projectId())];
        $project = $this->projectRepository->projectOfId($projectIds[0]);
        if ($project instanceof Project) {
            $organization = $this->organizationRepository->organizationOfId(
                $project->organizationId()
            );
            if (!$organization->isOrganizationMember(UserId::generate($query->userId()))) {
                throw new UnauthorizedProjectResourceException();
            }
        } else {
            $projects = $this->projectRepository->query(
                $this->projectSpecificationFactory->buildFilterableSpecification(
                    null,
                    UserId::generate($query->userId())
                )
            );
            $projectIds = array_map(function (Project $project) {
                return $project->id();
            }, $projects);
        }

        return $this->repository->count(
            $this->specificationFactory->buildFilterableSpecification(
                $projectIds,
                $query->title()
            )
        );
    }
}

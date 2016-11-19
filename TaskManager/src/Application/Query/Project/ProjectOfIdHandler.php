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

namespace Kreta\TaskManager\Application\Query\Project;

use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class ProjectOfIdHandler
{
    private $repository;
    private $organizationRepository;
    private $dataTransformer;

    public function __construct(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        ProjectDataTransformer $dataTransformer
    ) {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
        $this->organizationRepository = $organizationRepository;
    }

    public function __invoke(ProjectOfIdQuery $query)
    {
        $project = $this->repository->projectOfId(
            ProjectId::generate(
                $query->projectId()
            )
        );
        if (!$project instanceof Project) {
            throw new ProjectDoesNotExistException();
        }
        $organization = $this->organizationRepository->organizationOfId(
            $project->organizationId()
        );
        if (!$organization->isOrganizationMember(UserId::generate($query->userId()))) {
            throw new UnauthorizedProjectResourceException();
        }

        $this->dataTransformer->write($project);

        return $this->dataTransformer->read();
    }
}

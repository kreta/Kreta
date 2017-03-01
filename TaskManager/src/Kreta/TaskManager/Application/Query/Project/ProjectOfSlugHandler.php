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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class ProjectOfSlugHandler
{
    private $repository;
    private $specificationFactory;
    private $organizationRepository;
    private $dataTransformer;

    public function __construct(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory,
        ProjectDataTransformer $dataTransformer
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->dataTransformer = $dataTransformer;
        $this->organizationRepository = $organizationRepository;
    }

    public function __invoke(ProjectOfSlugQuery $query)
    {
        $projectSlug = new Slug($query->slug());
        $organizationSlug = new Slug($query->organizationSlug());
        $userId = UserId::generate($query->userId());

        $project = $this->repository->query(
            $this->specificationFactory->buildBySlugSpecification(
                $projectSlug,
                $organizationSlug
            )
        );
        $this->checkProjectExists($project);
        $organization = $this->organizationRepository->organizationOfSlug($organizationSlug);
        $this->checkUserIsOrganizationMember($organization, $userId);

        $this->dataTransformer->write($project);

        return $this->dataTransformer->read();
    }

    private function checkProjectExists(Project $project = null)
    {
        if (!$project instanceof Project) {
            throw new ProjectDoesNotExistException();
        }
    }

    private function checkUserIsOrganizationMember(Organization $organization, UserId $userId)
    {
        if (!$organization->isOrganizationMember($userId)) {
            throw new UnauthorizedProjectResourceException();
        }
    }
}

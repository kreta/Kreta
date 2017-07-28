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

namespace Kreta\TaskManager\Application\Command\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectAlreadyExists;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedCreateProjectException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CreateProjectHandler
{
    private $organizationRepository;
    private $repository;
    private $specificationFactory;

    public function __construct(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory
    ) {
        $this->organizationRepository = $organizationRepository;
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
    }

    public function __invoke(CreateProjectCommand $command)
    {
        $name = $command->name();
        $slug = $command->slug();
        $slug = new Slug(null === $slug ? $name : $slug);
        $name = new ProjectName($name);
        $projectId = ProjectId::generate($command->id());
        $organizationId = OrganizationId::generate($command->organizationId());
        $reporterId = UserId::generate($command->reporterId());

        $organization = $this->organizationRepository->organizationOfId($organizationId);
        $this->checkOrganizationExists($organization);
        $this->checkProjectUniqueness($projectId, $slug, $organization->slug());
        $this->checkReporterPrivileges($organization, $reporterId);

        $project = new Project($projectId, $name, $slug, $organizationId);
        $this->repository->persist($project);
    }

    private function checkOrganizationExists(?Organization $organization)
    {
        if (!$organization instanceof Organization) {
            throw new OrganizationDoesNotExistException();
        }
    }

    private function checkProjectUniqueness(ProjectId $projectId, Slug $slug, Slug $organizationSlug)
    {
        $this->checkProjectIdUniqueness($projectId);
        $this->checkProjectSlugUniqueness($slug, $organizationSlug);
    }

    private function checkProjectIdUniqueness(ProjectId $projectId)
    {
        $project = $this->repository->projectOfId($projectId);
        if ($project instanceof Project) {
            throw ProjectAlreadyExists::fromId($projectId);
        }
    }

    private function checkProjectSlugUniqueness(Slug $slug, Slug $organizationSlug)
    {
        $project = $this->repository->singleResultQuery(
            $this->specificationFactory->buildBySlugSpecification(
                $slug, $organizationSlug
            )
        );
        if ($project instanceof Project) {
            throw ProjectAlreadyExists::fromSlugs($slug, $organizationSlug);
        }
    }

    private function checkReporterPrivileges(Organization $organization, UserId $reporterId)
    {
        if (!$organization->isOwner($reporterId)) {
            throw new UnauthorizedCreateProjectException();
        }
    }
}

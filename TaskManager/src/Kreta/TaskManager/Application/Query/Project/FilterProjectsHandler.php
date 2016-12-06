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
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class FilterProjectsHandler
{
    private $repository;
    private $specificationFactory;
    private $dataTransformer;
    private $organizationRepository;
    private $organizationSpecificationFactory;

    public function __construct(
        OrganizationRepository $organizationRepository,
        OrganizationSpecificationFactory $organizationSpecificationFactory,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory,
        ProjectDataTransformer $dataTransformer
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->dataTransformer = $dataTransformer;
        $this->organizationRepository = $organizationRepository;
        $this->organizationSpecificationFactory = $organizationSpecificationFactory;
    }

    public function __invoke(FilterProjectsQuery $query)
    {
        $organizationIds = [OrganizationId::generate($query->organizationId())];
        $organization = $this->organizationRepository->organizationOfId($organizationIds[0]);
        if ($organization instanceof Organization) {
            if (!$organization->isOrganizationMember(UserId::generate($query->userId()))) {
                throw new UnauthorizedOrganizationActionException();
            }
        } else {
            $organizations = $this->organizationRepository->query(
                $this->organizationSpecificationFactory->buildFilterableSpecification(
                    null,
                    UserId::generate($query->userId())
                )
            );
            $organizationIds = array_map(function (Organization $organization) {
                return $organization->id();
            }, $organizations);
        }

        $projects = $this->repository->query(
            $this->specificationFactory->buildFilterableSpecification(
                $organizationIds,
                $query->name(),
                $query->offset(),
                $query->limit()
            )
        );

        return array_map(function (Project $project) {
            $this->dataTransformer->write($project);

            return $this->dataTransformer->read();
        }, $projects);
    }
}

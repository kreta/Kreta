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

use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CountProjectsHandler
{
    private $repository;
    private $specificationFactory;
    private $organizationRepository;
    private $organizationSpecificationFactory;

    public function __construct(
        OrganizationRepository $organizationRepository,
        OrganizationSpecificationFactory $organizationSpecificationFactory,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->organizationRepository = $organizationRepository;
        $this->organizationSpecificationFactory = $organizationSpecificationFactory;
    }

    public function __invoke(CountProjectsQuery $query) : int
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
        if (empty($organizationIds)) {
            return 0;
        }

        return $this->repository->count(
            $this->specificationFactory->buildFilterableSpecification(
                $organizationIds,
                $query->name()
            )
        );
    }
}

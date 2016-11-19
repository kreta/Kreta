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
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class FilterProjectsHandler
{
    private $repository;
    private $dataTransformer;
    private $specificationFactory;

    public function __construct(
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory,
        ProjectDataTransformer $dataTransformer
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->dataTransformer = $dataTransformer;
    }

    public function __invoke(FilterProjectsQuery $query)
    {
        $organizations = $this->repository->query(
            $this->specificationFactory->buildFilterableSpecification(
                UserId::generate($query->userId()),
                null === $query->organizationId() ? null : OrganizationId::generate($query->organizationId()),
                null === $query->name() ? null : new ProjectName($query->name()),
                $query->offset(),
                $query->limit()
            )
        );

        return array_map(function (Project $organization) {
            $this->dataTransformer->write($organization);

            return $this->dataTransformer->read();
        }, $organizations);
    }
}

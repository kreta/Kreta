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

namespace Kreta\TaskManager\Application\Query\Organization;

use Kreta\TaskManager\Application\DataTransformer\Organization\OrganizationDataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class FilterOrganizationsHandler
{
    private $repository;
    private $dataTransformer;
    private $specificationFactory;

    public function __construct(
        OrganizationRepository $repository,
        OrganizationSpecificationFactory $specificationFactory,
        OrganizationDataTransformer $dataTransformer
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
        $this->dataTransformer = $dataTransformer;
    }

    public function __invoke(FilterOrganizationsQuery $query)
    {
        $organizations = $this->repository->query(
            $this->specificationFactory->buildFilterableSpecification(
                $query->name(),
                UserId::generate($query->userId()),
                $query->offset(),
                $query->limit()
            )
        );

        return array_map(function (Organization $organization) {
            $this->dataTransformer->write($organization);

            return $this->dataTransformer->read();
        }, $organizations);
    }
}

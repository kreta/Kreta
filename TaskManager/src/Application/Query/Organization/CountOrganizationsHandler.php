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

use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CountOrganizationsHandler
{
    private $repository;
    private $specificationFactory;

    public function __construct(
        OrganizationRepository $repository,
        OrganizationSpecificationFactory $specificationFactory
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
    }

    public function __invoke(CountOrganizationsQuery $query)
    {
        return $this->repository->count(
            $this->specificationFactory->buildNameFilterableSpecification(
                $query->name(),
                UserId::generate(
                    $query->userId()
                )
            )
        );
    }
}

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

use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CountProjectsHandler
{
    private $repository;
    private $specificationFactory;

    public function __construct(
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory
    ) {
        $this->repository = $repository;
        $this->specificationFactory = $specificationFactory;
    }

    public function __invoke(CountProjectsQuery $query)
    {
        return $this->repository->count(
            $this->specificationFactory->buildNameFilterableSpecification(
                UserId::generate(
                    $query->userId()
                ),
                null === $query->name() ? null : new ProjectName($query->name())
            )
        );
    }
}

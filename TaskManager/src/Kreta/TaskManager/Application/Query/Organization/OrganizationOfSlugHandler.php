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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\DataTransformer\Organization\OrganizationDataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Infrastructure\Persistence\Doctrine\ORM\Organization\DoctrineORMBySlugSpecification;

class OrganizationOfSlugHandler
{
    private $repository;
    private $dataTransformer;

    public function __construct(OrganizationRepository $repository, OrganizationDataTransformer $dataTransformer)
    {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
    }

    public function __invoke(OrganizationOfSlugQuery $query)
    {
        $organization = $this->repository->query(
            new DoctrineORMBySlugSpecification(
                new Slug($query->organizationSlug())
            )
        );

        if (!$organization instanceof Organization) {
            throw new OrganizationDoesNotExistException();
        }
        if (!$organization->isOrganizationMember(UserId::generate($query->userId()))) {
            throw new UnauthorizedOrganizationActionException();
        }

        $this->dataTransformer->write($organization);

        return $this->dataTransformer->read();
    }
}

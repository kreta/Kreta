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

namespace Kreta\TaskManager\Application\Command\Organization;

use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedOrganizationActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class AddOrganizationMemberToOrganizationHandler
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddOrganizationMemberToOrganizationCommand $command)
    {
        $organization = $this->repository->organizationOfId(
            OrganizationId::generate(
                $command->organizationId()
            )
        );
        if (!$organization instanceof Organization) {
            throw new OrganizationDoesNotExistException();
        }

        if (!$organization->isOwner(UserId::generate($command->adderId()))) {
            throw new UnauthorizedOrganizationActionException();
        }

        $organization->addOrganizationMember(
            UserId::generate(
                $command->userId()
            )
        );

        $this->repository->persist($organization);
    }
}

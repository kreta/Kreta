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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\UnauthorizedEditOrganizationException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class EditOrganizationHandler
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditOrganizationCommand $command)
    {
        $organization = $this->repository->organizationOfId(
            OrganizationId::generate(
                $command->id()
            )
        );
        if (!$organization instanceof Organization) {
            throw new OrganizationDoesNotExistException();
        }
        if (!$organization->isOwner(UserId::generate($command->userId()))) {
            throw new UnauthorizedEditOrganizationException();
        }
        $organization->edit(
            new OrganizationName(
                $command->name()
            ),
            new Slug(
                null === $command->slug() ? $command->name() : $command->slug()
            )
        );
        $this->repository->persist($organization);
    }
}

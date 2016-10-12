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

namespace Kreta\TaskManager\Application\Organization;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;

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
        if (null === $organization) {
            throw new OrganizationDoesNotExistException();
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

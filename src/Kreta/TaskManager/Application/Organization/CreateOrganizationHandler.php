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
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OwnerDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Organization\OwnerRepository;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CreateOrganizationHandler
{
    private $ownerRepository;
    private $repository;

    public function __construct(OrganizationRepository $repository, OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
        $this->repository = $repository;
    }

    public function __invoke(CreateOrganizationCommand $command)
    {
        $owner = $this->ownerRepository->ownerOfId(
            OwnerId::generate(
                UserId::generate(
                    $command->userId()
                ),
                $command->ownerId()
            )
        );
        if (null === $owner) {
            throw new OwnerDoesNotExistException();
        }
        $slug = null === $command->slug() ? $command->name() : $command->slug();
        $organization = new Organization(
            OrganizationId::generate(
                $command->id()
            ),
            new OrganizationName(
                $command->name()
            ),
            new Slug(
                $slug
            ),
            $owner
        );

        $this->repository->persist($organization);
    }
}

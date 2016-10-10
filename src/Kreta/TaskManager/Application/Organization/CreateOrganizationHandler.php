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

use Kreta\SharedKernel\Domain\Model\Identity\EmailAddress;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\SharedKernel\Domain\Model\Identity\Username;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserDoesNotExistException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Domain\Model\User\UserRepository;

class CreateOrganizationHandler
{
    private $repository;
    private $userRepository;

    public function __construct(OrganizationRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateOrganizationCommand $command)
    {
        if (null !== $id = $command->id()) {
            $organization = $this->repository->organizationOfId(
                OrganizationId::generate(
                    $id
                )
            );
            if ($organization instanceof Organization) {
                throw new OrganizationAlreadyExistsException();
            }
        }
        $user = $this->userRepository->userOfId(
            UserId::generate(
                $command->userId()
            )
        );
        if (!$user instanceof User) {
            throw new UserDoesNotExistException();
        }
        $organization = new Organization(
            OrganizationId::generate(
                $command->id()
            ),
            new OrganizationName(
                $command->name()
            ),
            new Slug(
                null === $command->slug() ? $command->name() : $command->slug()
            ),
            new Owner(
                OwnerId::generate(
                    $user->id(),
                    $command->ownerId()
                ),
                new EmailAddress(
                    $command->ownerEmail()
                ),
                new Username(
                    $command->ownerUsername()
                )
            )
        );
        $this->repository->persist($organization);
    }
}

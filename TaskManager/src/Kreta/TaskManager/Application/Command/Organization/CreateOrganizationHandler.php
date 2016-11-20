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
use Kreta\TaskManager\Domain\Model\Organization\OrganizationAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
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
                $command->creatorId()
            )
        );
        if (!$user instanceof User) {
            throw new UserDoesNotExistException();
        }
        $organizationId = OrganizationId::generate($command->id());
        $organization = new Organization(
            $organizationId,
            new OrganizationName(
                $command->name()
            ),
            new Slug(
                null === $command->slug() ? $command->name() : $command->slug()
            ),
            $user->id()
        );
        $this->repository->persist($organization);
    }
}

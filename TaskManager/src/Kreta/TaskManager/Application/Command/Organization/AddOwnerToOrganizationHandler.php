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
use Kreta\TaskManager\Domain\Model\User\UserDoesNotExistException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Domain\Model\User\UserRepository;

class AddOwnerToOrganizationHandler
{
    private $repository;
    private $userRepository;

    public function __construct(OrganizationRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(AddOwnerToOrganizationCommand $command)
    {
        $adderId = UserId::generate($command->adderId());
        $userId = UserId::generate($command->userId());
        $organizationId = OrganizationId::generate($command->organizationId());

        $organization = $this->repository->organizationOfId($organizationId);
        $this->checkOrganizationExists($organization);
        $this->checkAdderIsOrganizationOwner($organization, $adderId);
        $this->checkUserExists($userId);
        $organization->addOwner($userId);
        $this->repository->persist($organization);
    }

    private function checkOrganizationExists(Organization $organization = null)
    {
        if (!$organization instanceof Organization) {
            throw new OrganizationDoesNotExistException();
        }
    }

    private function checkAdderIsOrganizationOwner(Organization $organization, UserId $adderId)
    {
        if (!$organization->isOwner($adderId)) {
            throw new UnauthorizedOrganizationActionException();
        }
    }

    private function checkUserExists(UserId $userId)
    {
        $user = $this->userRepository->userOfId($userId);
        if (null === $user) {
            throw new UserDoesNotExistException();
        }
    }
}

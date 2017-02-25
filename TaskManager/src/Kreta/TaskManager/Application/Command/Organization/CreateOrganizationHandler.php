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
        $name = $command->name();
        $slug = $command->slug();
        $slug = new Slug(null === $slug ? $name : $slug);
        $name = new OrganizationName($name);
        $organizationId = OrganizationId::generate($command->id());
        $creatorId = UserId::generate($command->creatorId());

        $this->checkOrganizationUniqueness($organizationId, $slug);
        $this->checkCreatorExists($creatorId);
        $organization = new Organization($organizationId, $name, $slug, $creatorId);
        $this->repository->persist($organization);
    }

    private function checkOrganizationUniqueness(OrganizationId $organizationId, Slug $slug)
    {
        $this->checkOrganizationIdUniqueness($organizationId);
        $this->checkOrganizationSlugUniqueness($slug);
    }

    private function checkOrganizationIdUniqueness(OrganizationId $organizationId)
    {
        $organization = $this->repository->organizationOfId($organizationId);
        if ($organization instanceof Organization) {
            throw new OrganizationAlreadyExistsException();
        }
    }

    private function checkOrganizationSlugUniqueness(Slug $slug)
    {
        $organization = $this->repository->organizationOfSlug($slug);
        if ($organization instanceof Organization) {
            throw new OrganizationAlreadyExistsException();
        }
    }

    private function checkCreatorExists(UserId $creatorId)
    {
        $creator = $this->userRepository->userOfId($creatorId);
        if (!$creator instanceof User) {
            throw new UserDoesNotExistException();
        }
    }
}

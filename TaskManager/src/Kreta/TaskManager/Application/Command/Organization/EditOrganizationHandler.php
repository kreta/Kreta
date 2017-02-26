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
        $name = $command->name();
        $slug = $command->slug();
        $slug = new Slug(null === $slug ? $name : $slug);
        $name = new OrganizationName($name);
        $organizationId = OrganizationId::generate($command->id());
        $editorId = UserId::generate($command->editorId());

        $organization = $this->repository->organizationOfId($organizationId);
        $this->checkOrganizationExists($organization);
        $this->checkEditorIsOrganizationOwner($organization, $editorId);
        $this->checkOrganizationSlugUniqueness($organizationId, $slug);
        $organization->edit($name, $slug);
        $this->repository->persist($organization);
    }

    private function checkOrganizationExists(Organization $organization = null)
    {
        if (null === $organization) {
            throw new OrganizationDoesNotExistException();
        }
    }

    private function checkOrganizationSlugUniqueness(OrganizationId $organizationId, Slug $slug)
    {
        $organization = $this->repository->organizationOfSlug($slug);
        if ($organization instanceof Organization && !$organizationId->equals($organization->id())) {
            throw new OrganizationAlreadyExistsException();
        }
    }

    private function checkEditorIsOrganizationOwner(Organization $organization, UserId $editorId)
    {
        if (!$organization->isOwner($editorId)) {
            throw new UnauthorizedEditOrganizationException();
        }
    }
}

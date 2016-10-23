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

namespace Kreta\TaskManager\Application\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectAlreadyExists;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedCreateProjectException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class CreateProjectHandler
{
    private $organizationRepository;
    private $projectRepository;

    public function __construct(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository
    ) {
        $this->organizationRepository = $organizationRepository;
        $this->projectRepository = $projectRepository;
    }

    public function __invoke(CreateProjectCommand $command)
    {
        $project = $this->projectRepository->projectOfId(
            ProjectId::generate($command->id())
        );

        if ($project instanceof Project) {
            throw new ProjectAlreadyExists($project->id());
        }

        $organizationId = OrganizationId::generate($command->organizationId());
        $organization = $this->organizationRepository->organizationOfId($organizationId);

        if (!$organization instanceof Organization) {
            throw new OrganizationDoesNotExistException();
        }

        if (!$organization->isOwner(UserId::generate($command->creatorId()))) {
            throw new UnauthorizedCreateProjectException();
        }

        $project = new Project(
            ProjectId::generate(
                $command->id()
            ),
            new ProjectName(
                $command->name()
            ),
            new Slug(
                null === $command->slug() ? $command->name() : $command->slug()
            ),
            $organization->id()
        );

        $this->projectRepository->persist($project);
    }
}

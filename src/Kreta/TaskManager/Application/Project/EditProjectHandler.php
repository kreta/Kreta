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
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectActionException;
use Kreta\TaskManager\Domain\Model\User\UserId;

class EditProjectHandler
{
    private $repository;
    private $organizationRepository;

    public function __construct(ProjectRepository $repository, OrganizationRepository $organizationRepository)
    {
        $this->repository = $repository;
        $this->organizationRepository = $organizationRepository;
    }

    public function __invoke(EditProjectCommand $command)
    {
        $project = $this->repository->projectOfId(
            ProjectId::generate($command->id())
        );
        if (!$project instanceof Project) {
            throw new ProjectDoesNotExistException();
        }

        $organization = $this->organizationRepository->organizationOfId(
            $project->organizationId()
        );

        if (!$organization->isOwner(UserId::generate($command->editorId()))) {
            throw new UnauthorizedProjectActionException();
        }

        $project->edit(
            new ProjectName($command->name()),
            new Slug(
                null === $command->slug() ? $command->name() : $command->slug()
            )
        );

        $this->repository->persist($project);
    }
}

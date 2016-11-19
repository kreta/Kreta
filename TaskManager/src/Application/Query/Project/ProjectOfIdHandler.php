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

namespace Kreta\TaskManager\Application\Query\Project;

use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDataTransformer;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;

class ProjectOfIdHandler
{
    private $repository;
    private $dataTransformer;

    public function __construct(ProjectRepository $repository, ProjectDataTransformer $dataTransformer)
    {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
    }

    public function __invoke(ProjectOfIdQuery $query)
    {
        $project = $this->repository->projectOfId(
            ProjectId::generate(
                $query->projectId()
            )
        );
        if (!$project instanceof Project) {
            throw new ProjectDoesNotExistException();
        }

        $this->dataTransformer->write($project);

        return $this->dataTransformer->read();
    }
}

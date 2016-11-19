<?php

declare(strict_types=1);

namespace Kreta\TaskManager\Application\DataTransformer\Project;

use Kreta\TaskManager\Domain\Model\Project\Project;

class ProjectDTODataTransformer implements ProjectDataTransformer
{
    private $project;

    public function write(Project $project)
    {
        $this->project = $project;
    }

    public function read()
    {
        if (!$this->project instanceof Project) {
            return [];
        }

        return [
            'id'              => $this->project->id()->id(),
            'name'            => $this->project->name()->name(),
            'slug'            => $this->project->slug()->slug(),
            'created_on'      => $this->project->createdOn()->format('Y-m-d'),
            'updated_on'      => $this->project->updatedOn()->format('Y-m-d'),
            'organization_id' => $this->project->organizationId()->id(),
        ];
    }
}

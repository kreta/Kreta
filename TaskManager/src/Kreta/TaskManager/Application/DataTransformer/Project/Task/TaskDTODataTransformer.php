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

namespace Kreta\TaskManager\Application\DataTransformer\Project\Task;

use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;

class TaskDTODataTransformer implements TaskDataTransformer
{
    private $task;
    private $organizationRepository;
    private $projectRepository;

    public function __construct(OrganizationRepository $organizationRepository, ProjectRepository $projectRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->projectRepository = $projectRepository;
    }

    public function write(Task $task)
    {
        $this->task = $task;
    }

    public function read()
    {
        if (!$this->task instanceof Task) {
            return [];
        }

        $project = $this->projectRepository->projectOfId(
            $this->task->projectId()
        );
        $organization = $this->organizationRepository->organizationOfId(
            $project->organizationId()
        );
        $assigneeId = null;
        $creatorId = null;
        foreach ($organization->organizationMembers() as $organizationMember) {
            if ($organizationMember->id()->equals($this->task->assigneeId())) {
                $assigneeId = $organizationMember->userId()->id();
            }
            if ($organizationMember->id()->equals($this->task->creatorId())) {
                $creatorId = $organizationMember->userId()->id();
            }
        }
        foreach ($organization->owners() as $owner) {
            if ($owner->id()->equals($this->task->assigneeId())) {
                $assigneeId = $owner->userId()->id();
            }
            if ($owner->id()->equals($this->task->creatorId())) {
                $creatorId = $owner->userId()->id();
            }
        }

        return [
            'id'          => $this->task->id()->id(),
            'title'       => $this->task->title()->title(),
            'priority'    => $this->task->priority()->priority(),
            'progress'    => $this->task->progress()->progress(),
            'description' => $this->task->description(),
            'assignee_id' => $assigneeId,
            'creator_id'  => $creatorId,
            'created_on'  => $this->task->createdOn()->format('Y-m-d'),
            'updated_on'  => $this->task->updatedOn()->format('Y-m-d'),
            'project_id'  => $this->task->projectId()->id(),
            'parent_id'   => null === $this->task->parentId() ? null : $this->task->parentId()->id(),
        ];
    }
}

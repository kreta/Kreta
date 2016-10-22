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

namespace Kreta\TaskManager\Application\Project\Task;

class CreateTaskCommand
{
    private $title;
    private $description;
    private $creatorId;
    private $assigneeId;
    private $priority;
    private $projectId;
    private $parentId;
    private $taskId;

    public function __construct(
        string $title,
        string $description,
        string $creatorId,
        string $assigneeId,
        string $priority,
        string $projectId,
        string $parentId = null,
        string $taskId = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->creatorId = $creatorId;
        $this->assigneeId = $assigneeId;
        $this->priority = $priority;
        $this->projectId = $projectId;
        $this->parentId = $parentId;
        $this->taskId = $taskId;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function creatorId() : string
    {
        return $this->creatorId;
    }

    public function assigneeId() : string
    {
        return $this->assigneeId;
    }

    public function priority() : string
    {
        return $this->priority;
    }

    public function projectId() : string
    {
        return $this->projectId;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function taskId()
    {
        return $this->taskId;
    }
}

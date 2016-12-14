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

namespace Kreta\TaskManager\Application\Query\Project\Task;

class FilterTasksQuery
{
    private $userId;
    private $projectId;
    private $offset;
    private $limit;
    private $title;
    private $parentId;
    private $priority;
    private $progress;
    private $assigneeId;
    private $creatorId;

    public function __construct(
        string $userId,
        int $offset,
        int $limit,
        string $parentId = null,
        string $projectId = null,
        string $title = null,
        string $priority = null,
        string $progress = null,
        string $assigneeId = null,
        string $creatorId = null
    ) {
        $this->title = $title;
        $this->projectId = $projectId;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->userId = $userId;
        $this->parentId = $parentId;
        $this->priority = $priority;
        $this->progress = $progress;
        $this->assigneeId = $assigneeId;
        $this->creatorId = $creatorId;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function offset() : int
    {
        return $this->offset;
    }

    public function limit() : int
    {
        return $this->limit;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function projectId()
    {
        return $this->projectId;
    }

    public function title() : ? string
    {
        return $this->title;
    }

    public function priority()
    {
        return $this->priority;
    }

    public function progress()
    {
        return $this->progress;
    }

    public function assigneeId()
    {
        return $this->assigneeId;
    }

    public function creatorId()
    {
        return $this->creatorId;
    }
}

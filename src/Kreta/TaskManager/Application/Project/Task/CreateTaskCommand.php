<?php

declare(strict_types = 1);

namespace Kreta\TaskManager\Application\Project\Task;

class CreateTaskCommand
{
    private $title;
    private $description;
    private $creatorMemberId;
    private $creatorUserId;
    private $assigneeMemberId;
    private $assigneeUserId;
    private $priority;
    private $projectId;
    private $parentId;
    private $taskId;

    public function __construct(
        string $title,
        string $description,
        string $creatorMemberId,
        string $creatorUserId,
        string $assigneeMemberId,
        string $assigneeUserId,
        string $priority,
        string $projectId,
        string $parentId = null,
        string $taskId = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->creatorMemberId = $creatorMemberId;
        $this->creatorUserId = $creatorUserId;
        $this->assigneeMemberId = $assigneeMemberId;
        $this->assigneeUserId = $assigneeUserId;
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

    public function creatorMemberId() : string
    {
        return $this->creatorMemberId;
    }

    public function creatorUserId() : string
    {
        return $this->creatorUserId;
    }

    public function assigneeMemberId() : string
    {
        return $this->assigneeMemberId;
    }

    public function assigneeUserId() : string
    {
        return $this->assigneeUserId;
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

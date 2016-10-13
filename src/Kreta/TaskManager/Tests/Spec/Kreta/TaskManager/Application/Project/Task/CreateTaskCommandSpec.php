<?php

namespace Spec\Kreta\TaskManager\Application\Project\Task;

use Kreta\TaskManager\Application\Project\Task\CreateTaskCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateTaskCommandSpec extends ObjectBehavior
{
    function it_can_be_created_with_basic_info()
    {
        $this->beConstructedWith(
            'title',
            'description',
            'creator-member-id',
            'creator-user-id',
            'assignee-member-id',
            'assignee-user-id',
            'priority',
            'project-id'
        );
        $this->shouldHaveType(CreateTaskCommand::class);
        $this->title()->shouldReturn('title');
        $this->description()->shouldReturn('description');
        $this->creatorMemberId()->shouldReturn('creator-member-id');
        $this->creatorUserId()->shouldReturn('creator-user-id');
        $this->assigneeMemberId()->shouldReturn('assignee-member-id');
        $this->assigneeUserId()->shouldReturn('assignee-user-id');
        $this->projectId()->shouldReturn('project-id');
        $this->parentId()->shouldReturn(null);
        $this->taskId()->shouldReturn(null);
    }

    function it_can_be_created_with_basic_info_and_parent()
    {
        $this->beConstructedWith(
            'title',
            'description',
            'creator-member-id',
            'creator-user-id',
            'assignee-member-id',
            'assignee-user-id',
            'priority',
            'project-id',
            'parent-id'
        );
        $this->title()->shouldReturn('title');
        $this->description()->shouldReturn('description');
        $this->creatorMemberId()->shouldReturn('creator-member-id');
        $this->creatorUserId()->shouldReturn('creator-user-id');
        $this->assigneeMemberId()->shouldReturn('assignee-member-id');
        $this->assigneeUserId()->shouldReturn('assignee-user-id');
        $this->projectId()->shouldReturn('project-id');
        $this->parentId()->shouldReturn('parent-id');
        $this->taskId()->shouldReturn(null);
    }

    function it_can_be_created_with_basic_info_and_parent_and_id()
    {
        $this->beConstructedWith(
            'title',
            'description',
            'creator-member-id',
            'creator-user-id',
            'assignee-member-id',
            'assignee-user-id',
            'priority',
            'project-id',
            'parent-id',
            'task-id'
        );
        $this->title()->shouldReturn('title');
        $this->description()->shouldReturn('description');
        $this->creatorMemberId()->shouldReturn('creator-member-id');
        $this->creatorUserId()->shouldReturn('creator-user-id');
        $this->assigneeMemberId()->shouldReturn('assignee-member-id');
        $this->assigneeUserId()->shouldReturn('assignee-user-id');
        $this->projectId()->shouldReturn('project-id');
        $this->parentId()->shouldReturn('parent-id');
        $this->taskId()->shouldReturn('task-id');
    }
}

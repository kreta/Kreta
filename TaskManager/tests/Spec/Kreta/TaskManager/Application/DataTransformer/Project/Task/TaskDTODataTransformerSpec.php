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

namespace Spec\Kreta\TaskManager\Application\DataTransformer\Project\Task;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\DataTransformer\Project\Task\TaskDataTransformer;
use Kreta\TaskManager\Application\DataTransformer\Project\Task\TaskDTODataTransformer;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\NumericId;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class TaskDTODataTransformerSpec extends ObjectBehavior
{
    function let(OrganizationRepository $organizationRepository, ProjectRepository $projectRepository)
    {
        $this->beConstructedWith($organizationRepository, $projectRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TaskDTODataTransformer::class);
        $this->shouldImplement(TaskDataTransformer::class);
    }

    function it_transform_task_to_plain_dto(
        ProjectRepository $projectRepository,
        OrganizationRepository $organizationRepository,
        Project $project,
        OrganizationId $organizationId
    ) {
        $projectId = ProjectId::generate('project-id');
        $assigneeId = UserId::generate('assignee-id');
        $reporterId = UserId::generate('reporter-id');

        $organization = new Organization(
            OrganizationId::generate('organization-id'),
            new OrganizationName('Organization name'),
            new Slug('Organization name'),
            UserId::generate()
        );
        $organization->addOwner($assigneeId);
        $organization->addOrganizationMember($reporterId);

        $assignee = $organization->organizationMember($assigneeId);
        $reporter = $organization->organizationMember($reporterId);

        $task = new Task(
            TaskId::generate('task-id'),
            NumericId::fromPrevious(2),
            new TaskTitle('The task title'),
            'The task description',
            $reporter->id(),
            $assignee->id(),
            TaskPriority::low(),
            $projectId,
            TaskId::generate('parent-id')
        );

        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);

        $this->write($task);

        $this->read()->shouldReturn([
            'id'          => 'task-id',
            'numeric_id'  => 3,
            'title'       => 'The task title',
            'priority'    => 'low',
            'progress'    => 'todo',
            'description' => 'The task description',
            'assignee_id' => 'assignee-id',
            'reporter_id'  => 'reporter-id',
            'created_on'  => (new \DateTimeImmutable())->format('Y-m-d'),
            'updated_on'  => (new \DateTimeImmutable())->format('Y-m-d'),
            'project_id'  => 'project-id',
            'parent_id'   => 'parent-id',
        ]);
    }

    function it_does_not_transformer_when_task_is_null()
    {
        $this->read()->shouldReturn([]);
    }
}

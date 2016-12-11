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

namespace Spec\Kreta\TaskManager\Application\Query\Project\Task;

use Kreta\TaskManager\Application\DataTransformer\Project\Task\TaskDataTransformer;
use Kreta\TaskManager\Application\Query\Project\Task\TaskOfIdHandler;
use Kreta\TaskManager\Application\Query\Project\Task\TaskOfIdQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskRepository;
use Kreta\TaskManager\Domain\Model\Project\Task\UnauthorizedTaskResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class TaskOfIdHandlerSpec extends ObjectBehavior
{
    function let(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $repository,
        TaskDataTransformer $dataTransformer
    ) {
        $this->beConstructedWith($organizationRepository, $projectRepository, $repository, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TaskOfIdHandler::class);
    }

    function it_serializes_task(
        TaskOfIdQuery $query,
        TaskRepository $repository,
        Task $task,
        ProjectId $projectId,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationId $organizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        TaskDataTransformer $dataTransformer
    ) {
        $query->taskId()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(true);
        $dataTransformer->write($task)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query);
    }

    function it_does_not_serialize_task_because_the_task_does_not_exist(
        TaskOfIdQuery $query,
        TaskRepository $repository
    ) {
        $query->taskId()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled();
        $this->shouldThrow(TaskDoesNotExistException::class)->during__invoke($query);
    }

    function it_does_not_serialize_task_when_the_user_does_not_allowed(
        TaskOfIdQuery $query,
        TaskRepository $repository,
        Task $task,
        ProjectId $projectId,
        ProjectRepository $projectRepository,
        Project $project,
        OrganizationId $organizationId,
        OrganizationRepository $organizationRepository,
        Organization $organization
    ) {
        $query->taskId()->shouldBeCalled()->willReturn('task-id');
        $repository->taskOfId(TaskId::generate('task-id'))->shouldBeCalled()->willReturn($task);
        $task->projectId()->shouldBeCalled()->willReturn($projectId);
        $projectRepository->projectOfId($projectId)->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $organization->isOrganizationMember(UserId::generate('user-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedTaskResourceException::class)->during__invoke($query);
    }
}

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

namespace Spec\Kreta\TaskManager\Application\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\Project\EditProjectCommand;
use Kreta\TaskManager\Application\Project\EditProjectHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectActionException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EditProjectHandlerSpec extends ObjectBehavior
{
    function let(ProjectRepository $projectRepository, OrganizationRepository $organizationRepository)
    {
        $this->beConstructedWith($projectRepository, $organizationRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditProjectHandler::class);
    }

    function it_edits_project(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        EditProjectCommand $command,
        Project $project,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $command->id()->willReturn('project-id');
        $command->name()->willReturn('Project name');
        $command->slug()->willReturn('project-name');
        $command->editorId()->willReturn('editor-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isOwner(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn(true);
        $project->edit(new ProjectName('Project name'), new Slug('project-name'))->shouldBeCalled();
        $projectRepository->persist(Argument::type(Project::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_edits_project_with_default_slug(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        EditProjectCommand $command,
        Project $project,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $command->id()->willReturn('project-id');
        $command->name()->willReturn('Project name');
        $command->slug()->willReturn(null);
        $command->editorId()->willReturn('editor-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isOwner(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn(true);
        $project->edit(new ProjectName('Project name'), new Slug('Project name'))->shouldBeCalled();
        $projectRepository->persist(Argument::type(Project::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_allow_to_edit_project_if_project_does_not_exist(
        ProjectRepository $projectRepository,
        EditProjectCommand $command
    ) {
        $command->id()->willReturn('project-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(ProjectDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_allow_to_edit_project_if_editor_is_not_organization_owner(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        EditProjectCommand $command,
        Project $project,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $command->id()->willReturn('project-id');
        $command->name()->willReturn('Project name');
        $command->slug()->willReturn(null);
        $command->editorId()->willReturn('editor-id');
        $projectRepository->projectOfId(ProjectId::generate('project-id'))->shouldBeCalled()->willReturn($project);
        $project->organizationId()->shouldBeCalled()->willReturn($organizationId);
        $organizationRepository->organizationOfId($organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isOwner(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedProjectActionException::class)->during__invoke($command);
    }
}

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

use Kreta\TaskManager\Application\Project\CreateProjectCommand;
use Kreta\TaskManager\Application\Project\CreateProjectHandler;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectAlreadyExists;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedCreateProjectException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateProjectHandlerSpec extends ObjectBehavior
{
    function let(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository
    ) {
        $this->beConstructedWith($organizationRepository, $projectRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateProjectHandler::class);
    }

    function it_creates_project(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        CreateProjectCommand $command,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $command->id()->willReturn('project-id');
        $command->name()->willReturn('Project name');
        $command->slug()->willReturn('project-name');
        $command->organizationId()->willReturn('organization-id');
        $command->creatorId()->willReturn('creator-id');

        $projectRepository->projectOfId(Argument::type(ProjectId::class))->shouldBeCalled()->willReturn(null);
        $organizationRepository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn($organization);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isOwner(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn(true);
        $projectRepository->persist(Argument::type(Project::class))->shouldBeCalled();

        $this->__invoke($command);
    }

    function it_creates_project_with_default_slug(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        CreateProjectCommand $command,
        Organization $organization,
        OrganizationId $organizationId
    ) {
        $command->id()->willReturn('project-id');
        $command->name()->willReturn('Project name');
        $command->slug()->willReturn(null);
        $command->organizationId()->willReturn('organization-id');
        $command->creatorId()->willReturn('creator-id');

        $projectRepository->projectOfId(Argument::type(ProjectId::class))->shouldBeCalled()->willReturn(null);
        $organizationRepository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn($organization);
        $organization->id()->shouldBeCalled()->willReturn($organizationId);
        $organization->isOwner(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn(true);
        $projectRepository->persist(Argument::type(Project::class))->shouldBeCalled();

        $this->__invoke($command);
    }

    function it_does_not_allow_to_create_project_if_id_already_exists(
        ProjectRepository $projectRepository,
        CreateProjectCommand $command,
        Project $project,
        ProjectId $projectId
    ) {
        $command->id()->willReturn('project-id');

        $projectRepository->projectOfId(Argument::type(ProjectId::class))->shouldBeCalled()->willReturn($project);
        $project->id()->willReturn($projectId);
        $this->shouldThrow(ProjectAlreadyExists::class)->during('__invoke', [$command]);
    }

    function it_does_not_allow_to_create_project_if_organization_does_not_exist(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        CreateProjectCommand $command,
        OrganizationId $organizationId
    ) {
        $command->id()->willReturn('project-id');
        $command->organizationId()->willReturn('organization-id');

        $projectRepository->projectOfId(Argument::type(ProjectId::class))->shouldBeCalled()->willReturn(null);
        $organizationRepository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(OrganizationDoesNotExistException::class)->during('__invoke', [$command]);
    }

    function it_does_not_allow_to_create_project_if_creator_is_not_organization_owner(
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository,
        CreateProjectCommand $command,
        Organization $organization
    ) {
        $command->id()->willReturn('project-id');
        $command->organizationId()->willReturn('organization-id');
        $command->creatorId()->willReturn('creator-id');

        $projectRepository->projectOfId(Argument::type(ProjectId::class))->shouldBeCalled()->willReturn(null);
        $organizationRepository->organizationOfId(Argument::type(OrganizationId::class))->shouldBeCalled()->willReturn($organization);
        $organization->isOwner(Argument::type(OwnerId::class))->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(UnauthorizedCreateProjectException::class)->during('__invoke', [$command]);
    }
}

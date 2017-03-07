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

namespace Spec\Kreta\TaskManager\Application\Command\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\Command\Project\CreateProjectCommand;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectAlreadyExists;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedCreateProjectException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateProjectHandlerSpec extends ObjectBehavior
{
    private $name;
    private $slug;
    private $id;
    private $organizationId;
    private $organizationSlug;
    private $creatorId;

    function let(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory,
        CreateProjectCommand $command
    ) {
        $this->beConstructedWith($organizationRepository, $repository, $specificationFactory);

        $command->name()->shouldBeCalled()->willReturn('The project name');
        $command->slug()->shouldBeCalled()->willReturn('the-project-slug');
        $command->id()->shouldBeCalled()->willReturn('project-id');
        $command->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $command->creatorId()->shouldBeCalled()->willReturn('creator-id');

        $this->name = new ProjectName('The project name');
        $this->slug = new Slug('the-project-slug');
        $this->id = ProjectId::generate('project-id');
        $this->organizationId = OrganizationId::generate('organization-id');
        $this->organizationSlug = new Slug('organization-slug');
        $this->creatorId = UserId::generate('creator-id');
    }

    function it_does_not_allow_to_create_project_if_organization_does_not_exist(
        OrganizationRepository $organizationRepository,
        CreateProjectCommand $command
    ) {
        $organizationRepository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(OrganizationDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_allow_to_create_project_if_id_already_exists(
        ProjectRepository $repository,
        CreateProjectCommand $command,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        Project $project
    ) {
        $organizationRepository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->slug()->shouldBeCalled()->willReturn($this->organizationSlug);
        $repository->projectOfId($this->id)->shouldBeCalled()->willReturn($project);
        $this->shouldThrow(ProjectAlreadyExists::class)->during__invoke($command);
    }

    function it_does_not_allow_to_create_project_if_slug_already_exists_in_organization(
        ProjectRepository $repository,
        CreateProjectCommand $command,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        ProjectSpecificationFactory $specificationFactory,
        Project $project
    ) {
        $organizationRepository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $organization->slug()->shouldBeCalled()->willReturn($this->organizationSlug);
        $repository->projectOfId($this->id)->shouldBeCalled()->willReturn(null);
        $specificationFactory->buildBySlugSpecification($this->slug, $this->organizationSlug)->shouldBeCalled();
        $repository->singleResultQuery(Argument::any())->shouldBeCalled()->willReturn($project);
        $this->shouldThrow(ProjectAlreadyExists::class)->during__invoke($command);
    }

    function it_does_not_allow_to_create_project_if_creator_is_not_organization_owner(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        CreateProjectCommand $command,
        Organization $organization,
        ProjectSpecificationFactory $specificationFactory
    ) {
        $organizationRepository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $repository->projectOfId($this->id)->shouldBeCalled()->willReturn(null);
        $organization->slug()->shouldBeCalled()->willReturn($this->organizationSlug);
        $specificationFactory->buildBySlugSpecification($this->slug, $this->organizationSlug)->shouldBeCalled();
        $repository->singleResultQuery(Argument::any())->shouldBeCalled()->willReturn(null);
        $organization->isOwner(UserId::generate('creator-id'))->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedCreateProjectException::class)->during__invoke($command);
    }

    function it_creates_project(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        CreateProjectCommand $command,
        Organization $organization,
        ProjectSpecificationFactory $specificationFactory
    ) {
        $organizationRepository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $repository->projectOfId($this->id)->shouldBeCalled()->willReturn(null);
        $organization->slug()->shouldBeCalled()->willReturn($this->organizationSlug);
        $specificationFactory->buildBySlugSpecification($this->slug, $this->organizationSlug)->shouldBeCalled();
        $repository->singleResultQuery(Argument::any())->shouldBeCalled()->willReturn(null);
        $organization->isOwner($this->creatorId)->shouldBeCalled()->willReturn(true);
        $repository->persist(Argument::type(Project::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_creates_project_with_default_slug(
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory,
        CreateProjectCommand $command,
        Organization $organization
    ) {
        $command->slug()->shouldBeCalled()->willReturn(null);
        $slug = new Slug('The project name');

        $organizationRepository->organizationOfId($this->organizationId)->shouldBeCalled()->willReturn($organization);
        $repository->projectOfId($this->id)->shouldBeCalled()->willReturn(null);
        $organization->slug()->shouldBeCalled()->willReturn($this->organizationSlug);
        $specificationFactory->buildBySlugSpecification($slug, $this->organizationSlug)->shouldBeCalled();
        $repository->singleResultQuery(Argument::any())->shouldBeCalled()->willReturn(null);
        $organization->isOwner($this->creatorId)->shouldBeCalled()->willReturn(true);
        $repository->persist(Argument::type(Project::class))->shouldBeCalled();
        $this->__invoke($command);
    }
}

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

namespace Spec\Kreta\TaskManager\Application\Query\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDataTransformer;
use Kreta\TaskManager\Application\Query\Project\ProjectOfSlugHandler;
use Kreta\TaskManager\Application\Query\Project\ProjectOfSlugQuery;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectResourceException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProjectOfSlugHandlerSpec extends ObjectBehavior
{
    private $slug;
    private $organizationSlug;
    private $userId;

    function let(
        ProjectOfSlugQuery $query,
        OrganizationRepository $organizationRepository,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory,
        ProjectDataTransformer $dataTransformer
    ) {
        $query->slug()->shouldBeCalled()->willReturn('project-slug');
        $query->organizationSlug()->shouldBeCalled()->willReturn('organization-slug');
        $query->userId()->shouldBeCalled()->willReturn('user-id');

        $this->slug = new Slug('project-slug');
        $this->organizationSlug = new Slug('organization-slug');
        $this->userId = UserId::generate('user-id');

        $this->beConstructedWith($organizationRepository, $repository, $specificationFactory, $dataTransformer);
    }

    function it_serializes_project(
        ProjectOfSlugQuery $query,
        ProjectRepository $repository,
        Project $project,
        OrganizationRepository $organizationRepository,
        Organization $organization,
        ProjectSpecificationFactory $specificationFactory,
        ProjectDataTransformer $dataTransformer
    ) {
        $this->shouldHaveType(ProjectOfSlugHandler::class);

        $specificationFactory->buildBySlugSpecification($this->slug, $this->organizationSlug)->shouldBeCalled();
        $repository->singleResultQuery(Argument::any())->shouldBeCalled()->willReturn($project);
        $organizationRepository->organizationOfSlug($this->organizationSlug)
            ->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember($this->userId)->shouldBeCalled()->willReturn(true);
        $dataTransformer->write($project)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query);
    }

    function it_does_not_serialize_project_when_the_project_does_not_exist(
        ProjectOfSlugQuery $query,
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory
    ) {
        $specificationFactory->buildBySlugSpecification($this->slug, $this->organizationSlug)->shouldBeCalled();
        $repository->singleResultQuery(Argument::any())->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(ProjectDoesNotExistException::class)->during__invoke($query);
    }

    function it_does_not_serialize_project_when_the_user_does_not_allowed(
        ProjectOfSlugQuery $query,
        ProjectRepository $repository,
        Project $project,
        ProjectSpecificationFactory $specificationFactory,
        OrganizationRepository $organizationRepository,
        Organization $organization
    ) {
        $specificationFactory->buildBySlugSpecification($this->slug, $this->organizationSlug)->shouldBeCalled();
        $repository->singleResultQuery(Argument::any())->shouldBeCalled()->willReturn($project);
        $organizationRepository->organizationOfSlug($this->organizationSlug)
            ->shouldBeCalled()->willReturn($organization);
        $organization->isOrganizationMember($this->userId)->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(UnauthorizedProjectResourceException::class)->during__invoke($query);
    }
}

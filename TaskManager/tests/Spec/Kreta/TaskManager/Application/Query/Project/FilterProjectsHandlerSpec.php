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

namespace Spec\Kreta\TaskManager\Application\Query\Project;

use Kreta\TaskManager\Application\DataTransformer\Project\ProjectDataTransformer;
use Kreta\TaskManager\Application\Query\Project\FilterProjectsHandler;
use Kreta\TaskManager\Application\Query\Project\FilterProjectsQuery;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterProjectsHandlerSpec extends ObjectBehavior
{
    function let(
        ProjectRepository $repository,
        ProjectSpecificationFactory $specificationFactory,
        ProjectDataTransformer $dataTransformer
    ) {
        $this->beConstructedWith($repository, $specificationFactory, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilterProjectsHandler::class);
    }

    function it_serializes_filtered_projects(
        FilterProjectsQuery $query,
        ProjectRepository $repository,
        Project $project,
        ProjectDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $query->name()->shouldBeCalled()->willReturn('project name');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$project]);
        $dataTransformer->write($project)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query)->shouldBeArray();
    }

    function it_serializes_filtered_projects_without_organization_id(
        FilterProjectsQuery $query,
        ProjectRepository $repository,
        Project $project,
        ProjectDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->organizationId()->shouldBeCalled()->willReturn(null);
        $query->name()->shouldBeCalled()->willReturn('project name');
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$project]);
        $dataTransformer->write($project)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query)->shouldBeArray();
    }

    function it_serializes_filtered_projects_without_project_name(
        FilterProjectsQuery $query,
        ProjectRepository $repository,
        Project $project,
        ProjectDataTransformer $dataTransformer
    ) {
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $query->organizationId()->shouldBeCalled()->willReturn('organization-id');
        $query->name()->shouldBeCalled()->willReturn(null);
        $query->offset()->shouldBeCalled()->willReturn(0);
        $query->limit()->shouldBeCalled()->willReturn(-1);
        $repository->query(Argument::any())->shouldBeCalled()->willReturn([$project]);
        $dataTransformer->write($project)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query)->shouldBeArray();
    }
}

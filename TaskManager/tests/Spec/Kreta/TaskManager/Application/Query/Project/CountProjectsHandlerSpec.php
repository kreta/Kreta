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

use Kreta\TaskManager\Application\Query\Project\CountProjectsHandler;
use Kreta\TaskManager\Application\Query\Project\CountProjectsQuery;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use Kreta\TaskManager\Domain\Model\Project\ProjectSpecificationFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountProjectsHandlerSpec extends ObjectBehavior
{
    function let(ProjectRepository $repository, ProjectSpecificationFactory $specificationFactory)
    {
        $this->beConstructedWith($repository, $specificationFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CountProjectsHandler::class);
    }

    function it_counts_projects(CountProjectsQuery $query, ProjectRepository $repository)
    {
        $query->name()->shouldBeCalled()->willReturn('organization name');
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(2);
        $this->__invoke($query)->shouldReturn(2);
    }

    function it_counts_without_project_name(CountProjectsQuery $query, ProjectRepository $repository)
    {
        $query->name()->shouldBeCalled()->willReturn(null);
        $query->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->count(Argument::any())->shouldBeCalled()->willReturn(3);
        $this->__invoke($query)->shouldReturn(3);
    }
}

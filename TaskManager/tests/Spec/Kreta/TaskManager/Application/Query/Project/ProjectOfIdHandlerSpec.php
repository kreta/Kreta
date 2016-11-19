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
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdHandler;
use Kreta\TaskManager\Application\Query\Project\ProjectOfIdQuery;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectDoesNotExistException;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;
use PhpSpec\ObjectBehavior;

class ProjectOfIdHandlerSpec extends ObjectBehavior
{
    function let(ProjectRepository $repository, ProjectDataTransformer $dataTransformer)
    {
        $this->beConstructedWith($repository, $dataTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectOfIdHandler::class);
    }

    function it_serializes_project(
        ProjectOfIdQuery $query,
        ProjectRepository $repository,
        Project $project,
        ProjectDataTransformer $dataTransformer
    ) {
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $repository->projectOfId(
            ProjectId::generate('project-id')
        )->shouldBeCalled()->willReturn($project);

        $dataTransformer->write($project)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled();
        $this->__invoke($query);
    }

    function it_does_not_serialize_project_because_the_project_does_not_exist(
        ProjectOfIdQuery $query,
        ProjectRepository $repository
    ) {
        $query->projectId()->shouldBeCalled()->willReturn('project-id');
        $repository->projectOfId(
            ProjectId::generate('project-id')
        )->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(ProjectDoesNotExistException::class)->during__invoke($query);
    }
}

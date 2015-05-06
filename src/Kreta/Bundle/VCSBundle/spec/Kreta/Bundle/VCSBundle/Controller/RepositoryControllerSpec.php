<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\VCSBundle\Controller;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use Kreta\Component\VCS\Repository\RepositoryRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RepositoryControllerSpec.
 *
 * @package spec\Kreta\Bundle\VCSBundle\Controller
 */
class RepositoryControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\Controller\RepositoryController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_repositories(
        ContainerInterface $container,
        Request $request,
        RepositoryRepository $repositoryRepository,
        ProjectInterface $project,
        RepositoryInterface $repository
    )
    {
        $container->get('kreta_vcs.repository.repository')->shouldBeCalled()->willReturn($repositoryRepository);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $repositoryRepository->findByProject($project)->shouldBeCalled()->willReturn([$repository]);

        $this->getRepositoriesAction($request, 'project-id')->shouldReturn([$repository]);
    }
}

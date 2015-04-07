<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Project\Model\Interfaces\PriorityInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\PriorityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PriorityControllerSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Controller
 */
class PriorityControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Controller\PriorityController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_priorities(
        ContainerInterface $container,
        Request $request,
        PriorityRepository $priorityRepository,
        ParamFetcher $paramFetcher,
        ProjectInterface $project,
        PriorityInterface $priority
    )
    {
        $container->get('kreta_project.repository.priority')->shouldBeCalled()->willReturn($priorityRepository);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('Low');
        $priorityRepository->findByProject($project, 10, 1, 'Low')->shouldBeCalled()->willReturn([$priority]);

        $this->getPrioritiesAction($request, 'project-id', $paramFetcher)->shouldReturn([$priority]);
    }

    function it_posts_priority(
        ContainerInterface $container,
        Request $request,
        ProjectInterface $project,
        Request $request,
        Handler $handler,
        PriorityInterface $priority
    )
    {
        $container->get('kreta_project.form_handler.priority')->shouldBeCalled()->willReturn($handler);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $handler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($priority);

        $this->postPrioritiesAction($request, 'project-id')->shouldReturn($priority);
    }

    function it_deletes_priority(
        ContainerInterface $container,
        PriorityRepository $priorityRepository,
        PriorityInterface $priority
    )
    {
        $container->get('kreta_project.repository.priority')->shouldBeCalled()->willReturn($priorityRepository);
        $priorityRepository->find('priority-id', false)->shouldBeCalled()->willReturn($priority);
        $priorityRepository->remove($priority)->shouldBeCalled();

        $this->deletePrioritiesAction('project-id', 'priority-id');
    }
}

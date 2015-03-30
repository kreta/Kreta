<?php

/**
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
use Kreta\Component\Project\Repository\ProjectRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

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

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_gets_priorities(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        PriorityRepository $priorityRepository,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $context,
        ProjectInterface $project,
        PriorityInterface $priority
    )
    {
        $project = $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $context);

        $container->get('kreta_project.repository.priority')->shouldBeCalled()->willReturn($priorityRepository);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('Low');
        $priorityRepository->findByProject($project, 10, 1, 'Low')
            ->shouldBeCalled()->willReturn([$priority]);

        $this->getPrioritiesAction('project-id', $paramFetcher)->shouldReturn([$priority]);
    }

    function it_does_not_get_priorities_because_the_user_has_not_the_required_grant(
        PriorityRepository $priorityRepository,
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_project.repository.priority')->shouldBeCalled()->willReturn($priorityRepository);
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getPrioritiesAction', ['project-id', $paramFetcher]);
    }

    function it_does_not_post_priority_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'create_priority', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('postPrioritiesAction', ['project-id']);
    }

    function it_posts_priority(
        ContainerInterface $container,
        Request $request,
        ProjectRepository $projectRepository,
        SecurityContextInterface $securityContext,
        ProjectInterface $project,
        Request $request,
        Handler $handler,
        PriorityInterface $priority
    )
    {
        $project = $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'create_priority'
        );

        $container->get('kreta_project.form_handler.priority')->shouldBeCalled()->willReturn($handler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($priority);

        $this->postPrioritiesAction('project-id')->shouldReturn($priority);
    }

    function it_does_not_delete_priority_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'delete_priority', false
        );

        $this->shouldThrow(new AccessDeniedException())
            ->during('deletePrioritiesAction', ['project-id', 'priority-id']);
    }

    function it_deletes_priority(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        PriorityRepository $priorityRepository,
        PriorityInterface $priority
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'delete_priority');
        $container->get('kreta_project.repository.priority')->shouldBeCalled()->willReturn($priorityRepository);
        $priorityRepository->find('priority-id', false)->shouldBeCalled()->willReturn($priority);
        $priorityRepository->remove($priority)->shouldBeCalled();

        $this->deletePrioritiesAction('project-id', 'priority-id');
    }

    protected function getProjectIfAllowedSpec(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->find('project-id', false)->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $project)->shouldBeCalled()->willReturn($result);

        return $project;
    }
}

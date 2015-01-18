<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\ApiBundle\Form\Handler\ProjectHandler;
use Kreta\Bundle\ApiBundle\spec\Kreta\Bundle\ApiBundle\Controller\BaseRestController;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProjectControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class ProjectControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\ProjectController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\RestController');
    }

    function it_gets_projects(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user,
        ProjectInterface $project
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($context);
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('name');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $projectRepository->findByParticipant($user, ['name' => 'ASC'], 10, 1)
            ->shouldBeCalled()->willReturn([$project]);

        $this->getProjectsAction($paramFetcher)->shouldReturn([$project]);
    }

    function it_does_not_get_project_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getProjectAction', ['project-id']);
    }

    function it_gets_project(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $project = $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext);

        $this->getProjectAction('project-id')->shouldReturn($project);
    }

    function it_posts_project(
        ContainerInterface $container,
        Request $request,
        ProjectHandler $projectHandler,
        ProjectInterface $project,
        Request $request
    )
    {
        $container->get('kreta_api.form_handler.project')->shouldBeCalled()->willReturn($projectHandler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $projectHandler->processForm($request)->shouldBeCalled()->willReturn($project);

        $this->postProjectsAction()->shouldReturn($project);
    }

    function it_puts_project_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        Request $request,
        ProjectHandler $projectHandler
    )
    {
        $container->get('kreta_api.form_handler.project')->shouldBeCalled()->willReturn($projectHandler);
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'edit', false);
        $container->get('request')->shouldBeCalled()->willReturn($request);

        $this->shouldThrow(new AccessDeniedException())->during('putProjectsAction', ['project-id']);
    }

    function it_puts_project(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        Request $request,
        ProjectHandler $projectHandler
    )
    {
        $container->get('kreta_api.form_handler.project')->shouldBeCalled()->willReturn($projectHandler);
        $project = $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'edit');
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $projectHandler->processForm($request, $project, ['method' => 'PUT'])->shouldBeCalled()->willReturn($project);

        $this->putProjectsAction('project-id')->shouldReturn($project);
    }
}

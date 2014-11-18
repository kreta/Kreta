<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\Api\ApiCoreBundle\Controller;

use FOS\RestBundle\View\ViewHandler;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Repository\ProjectRepository;
use Kreta\Component\Core\Repository\StatusRepository;
use Prophecy\Argument;
use spec\Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestControllerSpec;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class StatusTransitionControllerSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class StatusTransitionControllerSpec extends AbstractRestControllerSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\StatusTransitionController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_status_transitions_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_get_status_transitions_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_get_status_transitions_because_the_status_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            null
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('getTransitionsAction', ['project-id', 'status-id']);
    }

    function it_gets_status_transitions(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $status
        );

        $status->getTransitions()->shouldBeCalled()->willReturn([]);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getTransitionsAction('project-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_post_status_transition_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('postTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_post_status_transition_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'manage_status', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('postTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_post_status_transition_because_the_status_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            null,
            'manage_status'
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('postTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_post_status_transition_because_the_status_name_is_blank(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        Request $request
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('to')->shouldBeCalled()->willReturn('');

        $this->shouldThrow(new BadRequestHttpException('To status name should not be blank'))
            ->during('postTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_post_status_transition_because_the_to_status_name_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        Request $request
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('to')->shouldBeCalled()->willReturn('to-status-name');

        $statusRepository->findOneByNameAndProjectId('to-status-name', 'project-id')
            ->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any status with to-status-name name'))
            ->during('postTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_post_status_transition_because_the_from_status_and_the_to_status_are_equals(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $fromStatus,
        StatusInterface $toStatus,
        Request $request
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $fromStatus,
            'manage_status'
        );

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('to')->shouldBeCalled()->willReturn('to-status-name');

        $statusRepository->findOneByNameAndProjectId('to-status-name', 'project-id')
            ->shouldBeCalled()->willReturn($toStatus);

        $toStatus->getId()->shouldBeCalled()->willReturn('status-id');
        $fromStatus->getId()->shouldBeCalled()->willReturn('status-id');

        $this->shouldThrow(new BadRequestHttpException('From status and to status are equals'))
            ->during('postTransitionsAction', ['project-id', 'status-id']);
    }

    function it_does_not_post_status_transition_because_the_transition_is_already_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $fromStatus,
        StatusInterface $toStatus,
        StatusInterface $status,
        Request $request
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $fromStatus,
            'manage_status'
        );

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('to')->shouldBeCalled()->willReturn('to-status-name');

        $statusRepository->findOneByNameAndProjectId('to-status-name', 'project-id')
            ->shouldBeCalled()->willReturn($toStatus);

        $toStatus->getId()->shouldBeCalled()->willReturn('to-status-id');
        $fromStatus->getId()->shouldBeCalled()->willReturn('status-id');

        $fromStatus->getTransitions()->shouldBeCalled()->willReturn([$status]);
        $status->getId()->shouldBeCalled()->willReturn('to-status-id');
        $toStatus->getId()->shouldBeCalled()->willReturn('to-status-id');
        $toStatus->getName()->shouldBeCalled()->willReturn('to-status-name');

        $this->shouldThrow(new BadRequestHttpException('The to-status-name transition is already exist'))
            ->during('postTransitionsAction', ['project-id', 'status-id']);
    }

    function it_posts_status_transition(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $fromStatus,
        StatusInterface $toStatus,
        StatusInterface $status,
        Request $request,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $fromStatus,
            'manage_status'
        );

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('to')->shouldBeCalled()->willReturn('to-status-name');

        $statusRepository->findOneByNameAndProjectId('to-status-name', 'project-id')
            ->shouldBeCalled()->willReturn($toStatus);

        $toStatus->getId()->shouldBeCalled()->willReturn('to-status-id');
        $fromStatus->getId()->shouldBeCalled()->willReturn('status-id');

        $fromStatus->getTransitions()->shouldBeCalled()->willReturn([$status]);
        $status->getId()->shouldBeCalled()->willReturn('transition-status-id');
        $toStatus->getId()->shouldBeCalled()->willReturn('to-status-id');

        $fromStatus->addStatusTransition($toStatus)->shouldBeCalled()->willReturn($fromStatus);
        $statusRepository->save($fromStatus)->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postTransitionsAction('project-id', 'status-id')->shouldReturn($response);;
    }

    function it_does_not_delete_status_transition_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('deleteTransitionsAction', ['project-id', 'status-id', 'transition-id']);
    }

    function it_does_not_post_delete_transition_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'manage_status', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('deleteTransitionsAction', ['project-id', 'status-id', 'transition-id']);
    }

    function it_does_not_delete_status_transition_because_the_status_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            null,
            'manage_status'
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('deleteTransitionsAction', ['project-id', 'status-id', 'transition-id']);
    }

    function it_does_not_delete_status_transition_because_the_status_transition_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        StatusInterface $transition,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $status->getTransitions()->shouldBeCalled()->willReturn([$transition]);
        $transition->getId()->shouldBeCalled()->willReturn('unknown-transition-id');

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->deleteTransitionsAction('project-id', 'status-id', 'transition-id')->shouldReturn($response);
    }

    function it_deletes_status_transition(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        StatusInterface $transition,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $projectRepository,
            $project,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $status->getTransitions()->shouldBeCalled()->willReturn([$transition]);
        $transition->getId()->shouldBeCalled()->willReturn('transition-id');

        $status->removeStatusTransition($transition)->shouldBeCalled()->willReturn($status);
        $statusRepository->save($status)->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->deleteTransitionsAction('project-id', 'status-id', 'transition-id')->shouldReturn($response);
    }
}

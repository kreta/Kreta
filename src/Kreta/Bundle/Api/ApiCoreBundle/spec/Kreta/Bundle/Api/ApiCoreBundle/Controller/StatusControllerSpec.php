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

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\View\ViewHandler;
use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\StatusType;
use Kreta\Component\Core\Factory\StatusFactory;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Repository\ProjectRepository;
use Kreta\Component\Core\Repository\StatusRepository;
use Prophecy\Argument;
use spec\Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestControllerSpec;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class StatusControllerSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class StatusControllerSpec extends AbstractRestControllerSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\StatusController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_statuses_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getStatusesAction', ['project-id']);
    }

    function it_does_not_get_statuses_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getStatusesAction', ['project-id']);
    }

    function it_gets_statuses(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getStatusesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_get_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getStatusAction', ['project-id', 'status-id']);
    }

    function it_does_not_get_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getStatusAction', ['project-id', 'status-id']);
    }

    function it_does_not_get_status_because_the_status_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $this->getStatusIfAllowed($container, $projectRepository, $project, $securityContext, $statusRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('getStatusAction', ['project-id', 'status-id']);
    }

    function it_gets_status(
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

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getStatusAction('project-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_post_status_because_the_name_is_blank(ContainerInterface $container, Request $request)
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('');

        $this->shouldThrow(new BadRequestHttpException('Name should not be blank'))
            ->during('postStatusesAction', ['project-id']);
    }

    function it_does_not_post_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('postStatusesAction', ['project-id']);
    }

    function it_does_not_post_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'manage_status', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('postStatusesAction', ['project-id']);
    }

    function it_posts_status(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'manage_status');

        $status->setProject($project)->shouldBeCalled()->willReturn($status);

        $this->processForm(
            $container,
            $request,
            $formFactory,
            $form,
            $registry,
            $manager,
            $viewHandler,
            $response,
            new StatusType(),
            $status
        );

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postStatusesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_posts_status_because_there_are_some_form_errors(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_core.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'manage_status');

        $status->setProject($project)->shouldBeCalled()->willReturn($status);

        $this->getFormErrors(
            $container,
            $request,
            $formFactory,
            $form,
            $error,
            $formChild,
            $formGrandChild,
            $viewHandler,
            $response,
            new StatusType(),
            $status
        );

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postStatusesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_put_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('putStatusesAction', ['project-id', 'status-id']);
    }

    function it_does_not_put_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'manage_status', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('putStatusesAction', ['project-id', 'status-id']);
    }

    function it_does_not_put_status_because_the_status_does_not_exist(
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
            ->during('putStatusesAction', ['project-id', 'status-id']);
    }

    function it_puts_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
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

        $this->processForm(
            $container,
            $request,
            $formFactory,
            $form,
            $registry,
            $manager,
            $viewHandler,
            $response,
            new StatusType(),
            $status,
            'PUT'
        );

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->putStatusesAction('project-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_puts_status_because_there_are_some_form_errors(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
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

        $this->getFormErrors(
            $container,
            $request,
            $formFactory,
            $form,
            $error,
            $formChild,
            $formGrandChild,
            $viewHandler,
            $response,
            new StatusType(),
            $status,
            'PUT'
        );

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->putStatusesAction('project-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_delete_status_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('deleteStatusesAction', ['project-id', 'status-id']);
    }

    function it_does_not_delete_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'manage_status', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('deleteStatusesAction', ['project-id', 'status-id']);
    }

    function it_does_not_delete_status_because_the_status_does_not_exist(
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
            ->during('deleteStatusesAction', ['project-id', 'status-id']);
    }

    function it_deletes_status(
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
            $status,
            'manage_status'
        );

        $statusRepository->delete($status)->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->deleteStatusesAction('project-id', 'status-id')->shouldReturn($response);
    }
}

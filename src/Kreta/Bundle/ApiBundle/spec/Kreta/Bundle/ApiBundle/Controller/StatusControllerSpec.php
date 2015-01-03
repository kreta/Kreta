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

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\ViewHandler;
use Kreta\Bundle\ApiBundle\Form\Handler\StatusHandler;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Workflow\Factory\StatusFactory;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use Prophecy\Argument;
use spec\Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestControllerSpec;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class StatusControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class StatusControllerSpec extends AbstractRestControllerSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\StatusController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_statuses_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('getStatusesAction', ['workflow-id']);
    }

    function it_does_not_get_statuses_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getStatusesAction', ['workflow-id']);
    }

    function it_gets_statuses(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getStatusesAction('workflow-id')->shouldReturn($response);
    }

    function it_does_not_get_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('getStatusAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_get_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getStatusAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_get_status_because_the_status_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $this->getStatusIfAllowed($container, $workflowRepository, $workflow, $securityContext, $statusRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('getStatusAction', ['workflow-id', 'status-id']);
    }

    function it_gets_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $statusRepository,
            $status
        );

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getStatusAction('workflow-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_post_status_because_the_name_is_blank(ContainerInterface $container, Request $request)
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('');

        $this->shouldThrow(new BadRequestHttpException('Name should not be blank'))
            ->during('postStatusesAction', ['workflow-id']);
    }

    function it_does_not_post_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        WorkflowRepository $workflowRepository
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_workflow.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('postStatusesAction', ['workflow-id']);
    }

    function it_does_not_post_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        Request $request,
        StatusFactory $statusFactory,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_workflow.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('postStatusesAction', ['workflow-id']);
    }

    function it_posts_status(
        ContainerInterface $container,
        Request $request,
        FormInterface $form,
        ViewHandler $viewHandler,
        Response $response,
        StatusHandler $statusHandler,
        StatusFactory $statusFactory,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        Request $request,
        FormInterface $form,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_workflow.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'manage_status');

        $status->setWorkflow($workflow)->shouldBeCalled()->willReturn($status);

        $this->processForm(
            $container,
            $request,
            $form,
            $viewHandler,
            $statusHandler,
            $response,
            $status
        );

        $this->postStatusesAction('workflow-id')->shouldReturn($response);
    }

    function it_does_not_posts_status_because_there_are_some_form_errors(
        ContainerInterface $container,
        StatusFactory $statusFactory,
        StatusInterface $status,
        StatusHandler $statusHandler,
        SecurityContextInterface $securityContext,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        Request $request,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-name');

        $container->get('kreta_workflow.factory.status')->shouldBeCalled()->willReturn($statusFactory);
        $statusFactory->create('status-name')->shouldBeCalled()->willReturn($status);

        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'manage_status');

        $status->setWorkflow($workflow)->shouldBeCalled()->willReturn($status);

        $this->getFormErrors(
            $container,
            $request,
            $form,
            $error,
            $formChild,
            $formGrandChild,
            $response,
            $viewHandler,
            $statusHandler,
            $status
        );

        $this->postStatusesAction('workflow-id')->shouldReturn($response);
    }

    function it_does_not_put_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        StatusHandler $statusHandler,
        WorkflowRepository $workflowRepository
    )
    {
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);

        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('putStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_put_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        StatusHandler $statusHandler,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);

        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('putStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_put_status_because_the_status_does_not_exist(
        ContainerInterface $container,
        StatusHandler $statusHandler,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);

        $this->getStatusIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $statusRepository,
            null,
            'manage_status'
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('putStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_puts_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        StatusHandler $statusHandler,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        FormInterface $form,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);

        $this->getStatusIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $this->processForm(
            $container,
            $request,
            $form,
            $viewHandler,
            $statusHandler,
            $response,
            $status,
            'PUT'
        );

        $this->putStatusesAction('workflow-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_puts_status_because_there_are_some_form_errors(
        ContainerInterface $container,
        StatusHandler $statusHandler,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);

        $this->getStatusIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $this->getFormErrors(
            $container,
            $request,
            $form,
            $error,
            $formChild,
            $formGrandChild,
            $response,
            $viewHandler,
            $statusHandler,
            $status,
            'PUT'
        );

        $this->putStatusesAction('workflow-id', 'status-id')->shouldReturn($response);
    }

    function it_does_not_delete_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_delete_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_delete_status_because_the_status_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $statusRepository,
            null,
            'manage_status'
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with status-id id'))
            ->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_delete_status_because_the_status_is_in_use(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        IssueRepository $issueRepository,
        IssueInterface $issue
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findByWorkflow($workflow)->shouldBeCalled()->willReturn([$issue]);
        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getId()->shouldBeCalled()->willReturn('status-id');

        $this->shouldThrow(
            new HttpException(
                Codes::HTTP_FORBIDDEN,
                'Remove operation has been cancelled, the status is currently in use'
            )
        )->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_deletes_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        StatusRepository $statusRepository,
        StatusInterface $status,
        StatusInterface $status2,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getStatusIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $statusRepository,
            $status,
            'manage_status'
        );

        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findByWorkflow($workflow)->shouldBeCalled()->willReturn([$issue]);
        $issue->getStatus()->shouldBeCalled()->willReturn($status2);
        $status->getId()->shouldBeCalled()->willReturn('status-id-1');
        $status2->getId()->shouldBeCalled()->willReturn('status-id-2');

        $statusRepository->delete($status)->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->deleteStatusesAction('workflow-id', 'status-id')->shouldReturn($response);
    }
}

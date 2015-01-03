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
use Kreta\Bundle\ApiBundle\Form\Handler\StatusTransitionHandler;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Workflow\Factory\StatusTransitionFactory;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Kreta\Component\Workflow\Repository\StatusTransitionRepository;
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
 * Class StatusTransitionControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class StatusTransitionControllerSpec extends AbstractRestControllerSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\StatusTransitionController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_status_transitions_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('getTransitionsAction', ['workflow-id']);
    }

    function it_does_not_get_status_transitions_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getTransitionsAction', ['workflow-id']);
    }

    function it_gets_status_transitions(
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

        $this->getTransitionsAction('workflow-id')->shouldReturn($response);
    }

    function it_does_not_get_status_transition_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('getTransitionAction', ['workflow-id', 'status-transition-name']);
    }

    function it_does_not_get_status_transition_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getTransitionAction', ['workflow-id', 'status-transition-name']);
    }

    function it_does_not_get_status_transition_because_the_status_transition_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository
    )
    {
        $this->getTransitionIfAllowed($container, $workflowRepository, $workflow, $securityContext, $statusRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with transition-id id'))
            ->during('getTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_gets_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition
        );

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getTransitionAction('workflow-id', 'transition-id')->shouldReturn($response);
    }

    function it_does_not_post_status_transition_because_the_name_is_blank(
        ContainerInterface $container,
        Request $request
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('');

        $this->shouldThrow(new BadRequestHttpException('Name should not be blank'))
            ->during('postTransitionsAction', ['workflow-id']);
    }

    function it_does_not_post_status_transition_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        Request $request,
        WorkflowRepository $workflowRepository
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-transition-name');

        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('postTransitionsAction', ['workflow-id']);
    }

    function it_does_not_post_status_transition_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        Request $request,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-transition-name');

        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('postTransitionsAction', ['workflow-id']);
    }

    function it_does_not_post_status_transition_because_it_must_have_at_least_one_initial(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        Request $request
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-transition-name');

        $workflow = $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status'
        );

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $request->get('initials')->shouldBeCalled()->willReturn('status-id');
        $statusRepository->findByIds('status-id', $workflow)->shouldBeCalled()->willReturn([]);

        $this->shouldThrow(new BadRequestHttpException('The initial status is missing or does not exist'))
            ->during('postTransitionsAction', ['workflow-id']);
    }

    function it_posts_status_transition(
        ContainerInterface $container,
        Request $request,
        FormInterface $form,
        ViewHandler $viewHandler,
        Response $response,
        StatusTransitionHandler $transitionHandler,
        StatusTransitionFactory $transitionFactory,
        StatusTransitionInterface $transition,
        StatusRepository $statusRepository,
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
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-transition-name');

        $workflow = $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status'
        );

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $request->get('initials')->shouldBeCalled()->willReturn('status-id');
        $statusRepository->findByIds('status-id', $workflow)->shouldBeCalled()->willReturn([$status]);

        $container->get('kreta_workflow.factory.status_transition')->shouldBeCalled()->willReturn($transitionFactory);
        $transitionFactory->create('status-transition-name', null, [$status])
            ->shouldBeCalled()->willReturn($transition);

        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);

        $container->get('kreta_api.form_handler.status_transition')->shouldBeCalled()->willReturn($transitionHandler);
        $transitionHandler->handleForm(
            $request,
            $transition,
            ['csrf_protection' => false, 'method' => 'POST', 'states' => [$status]]
        )->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postTransitionsAction('workflow-id')->shouldReturn($response);
    }

    function it_does_not_posts_status_transition_because_there_are_some_form_errors(
        ContainerInterface $container,
        StatusTransitionFactory $transitionFactory,
        StatusTransitionInterface $transition,
        StatusTransitionHandler $transitionHandler,
        SecurityContextInterface $securityContext,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        StatusRepository $statusRepository,
        StatusInterface $status,
        Request $request,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('name')->shouldBeCalled()->willReturn('status-transition-name');

        $workflow = $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status'
        );

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $request->get('initials')->shouldBeCalled()->willReturn('status-id');
        $statusRepository->findByIds('status-id', $workflow)->shouldBeCalled()->willReturn([$status]);

        $container->get('kreta_workflow.factory.status_transition')->shouldBeCalled()->willReturn($transitionFactory);
        $transitionFactory->create('status-transition-name', null, [$status])
            ->shouldBeCalled()->willReturn($transition);

        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);

        $container->get('kreta_api.form_handler.status_transition')->shouldBeCalled()->willReturn($transitionHandler);
        $transitionHandler->handleForm(
            $request,
            $transition,
            ['csrf_protection' => false, 'method' => 'POST', 'states' => [$status]]
        )->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->getErrors()->shouldBeCalled()->willReturn([$error]);
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $form->all()->shouldBeCalled()->willReturn([$formChild]);
        $formChild->isValid()->shouldBeCalled()->willReturn(false);
        $formChild->getName()->shouldBeCalled()->willReturn('form child name');
        $formChild->getErrors()->shouldBeCalled()->willReturn([$error]);
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $formChild->all()->shouldBeCalled()->willReturn([$formGrandChild]);
        $formGrandChild->isValid()->shouldBeCalled()->willReturn(true);
        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postTransitionsAction('workflow-id')->shouldReturn($response);
    }

    function it_does_not_delete_status_transition_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('deleteTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_delete_status_transition_because_the_user_has_not_the_required_grant(
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
            ->during('deleteTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_delete_status_transition_because_the_transition_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository
    )
    {
        $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            null,
            'manage_status'
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with transition-id id'))
            ->during('deleteTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_delete_status_transition_because_it_is_in_use(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusInterface $status,
        IssueRepository $issueRepository,
        IssueInterface $issue
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $status,
            'manage_status'
        );

        $transition->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findByWorkflow($workflow)->shouldBeCalled()->willReturn([$issue]);
        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getTransitions()->shouldBeCalled()->willReturn([$transition]);
        $transition->getId()->shouldBeCalled()->willReturn('transition-id');

        $this->shouldThrow(
            new HttpException(
                Codes::HTTP_BAD_REQUEST,
                'Remove operation has been cancelled, the transition is currently in use'
            )
        )->during('deleteTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_deletes_status_transition(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        StatusInterface $status,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition2,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $status,
            'manage_status'
        );

        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findByWorkflow($workflow)->shouldBeCalled()->willReturn([$issue]);
        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getTransitions()->shouldBeCalled()->willReturn([$transition2]);
        $transition->getId()->shouldBeCalled()->willReturn('transition-id');
        $transition2->getId()->shouldBeCalled()->willReturn('transition-id-2');

        $transitionRepository->delete($transition)->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->deleteTransitionAction('workflow-id', 'transition-id')->shouldReturn($response);
    }

    function it_does_not_get_initial_statuses_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('getTransitionsInitialStatusesAction', ['workflow-id', 'status-transition-id']);
    }

    function it_does_not_get_initial_statuses_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getTransitionsInitialStatusesAction', ['workflow-id', 'status-transition-id']);
    }

    function it_does_not_get_initial_statuses_because_the_status_transition_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository
    )
    {
        $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $transitionRepository
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with transition-id id'))
            ->during('getTransitionsInitialStatusesAction', ['workflow-id', 'transition-id']);
    }

    function it_gets_initial_statuses(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $initial,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition
        );

        $transition->getInitialStates()->shouldBeCalled()->willReturn([$initial]);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getTransitionsInitialStatusesAction('workflow-id', 'transition-id')->shouldReturn($response);
    }

    function it_does_not_get_initial_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('getTransitionsInitialStatusAction', ['workflow-id', 'status-transition-id', 'initial-id']);
    }

    function it_does_not_get_initial_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getTransitionsInitialStatusAction', ['workflow-id', 'status-transition-id', 'initial-id']);
    }

    function it_does_not_get_initial_status_because_the_status_transition_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository
    )
    {
        $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $transitionRepository
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with transition-id id'))
            ->during('getTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_does_not_get_initial_status_because_the_initial_status_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition
        );

        $transition->getInitialStates()->shouldBeCalled()->willReturn([]);

        $this->shouldThrow(
            new NotFoundHttpException(sprintf('Does not exist any initial status with %s id', 'initial-id'))
        )->during('getTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_gets_initial_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $initial,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition
        );

        $transition->getInitialStates()->shouldBeCalled()->willReturn([$initial]);
        $initial->getId()->shouldBeCalled()->willReturn('initial-id');

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getTransitionsInitialStatusAction('workflow-id', 'transition-id', 'initial-id')->shouldReturn($response);
    }

    function it_does_not_post_initial_status_because_it_does_pass_initial_status_id(
        ContainerInterface $container,
        Request $request
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new BadRequestHttpException('The initial status should not be blank'))
            ->during('postTransitionsInitialStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_post_initial_status_because_it_does_exist_initial_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn('initial-status-id');

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('initial-status-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(
            new NotFoundHttpException(sprintf('Does not exist any initial status with %s id', 'initial-status-id'))
        )->during('postTransitionsInitialStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_post_initial_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        WorkflowRepository $workflowRepository
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn('initial-status-id');

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('initial-status-id')->shouldBeCalled()->willReturn($status);

        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('postTransitionsInitialStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_post_initial_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn('initial-status-id');

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('initial-status-id')->shouldBeCalled()->willReturn($status);

        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('postTransitionsInitialStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_post_initial_status_because_the_status_transition_does_not_exist(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn('initial-status-id');

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('initial-status-id')->shouldBeCalled()->willReturn($status);

        $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $transitionRepository, null, 'manage_status'
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with transition-id id'))
            ->during('postTransitionsInitialStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_posts_initial_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn('initial-status-id');

        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('initial-status-id')->shouldBeCalled()->willReturn($status);

        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition,
            'manage_status'
        );

        $transition->addInitialState($status)->shouldBeCalled()->willReturn($transition);
        $transitionRepository->save($transition)->shouldBeCalled();
        $transition->getInitialStates()->shouldBeCalled()->willReturn([$status]);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postTransitionsInitialStatusAction('workflow-id', 'transition-id')->shouldReturn($response);
    }

    function it_does_not_delete_initial_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_does_not_delete_initial_status_because_the_user_has_not_the_required_grant(
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
            ->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_does_not_delete_initial_status_because_the_status_transition_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository
    )
    {
        $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $transitionRepository, null, 'manage_status'
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with transition-id id'))
            ->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_does_not_delete_initial_status_because_transition_is_currently_in_use(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition,
            'manage_status'
        );

        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $transition->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $issueRepository->findByWorkflow($workflow)->shouldBeCalled()->willReturn([$issue]);

        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getTransitions()->shouldBeCalled()->willReturn([$transition]);
        $transition->getId()->shouldBeCalled()->willReturn('transition-id');

        $this->shouldThrow(
            new HttpException(
                Codes::HTTP_BAD_REQUEST, 'Remove operation has been cancelled, the transition is currently in use')
        )->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_does_not_delete_initial_status_because_does_not_exist_any_initial_with_id_given(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusTransitionInterface $transition2
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition,
            'manage_status'
        );

        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $transition->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $issueRepository->findByWorkflow($workflow)->shouldBeCalled()->willReturn([$issue]);

        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getTransitions()->shouldBeCalled()->willReturn([$transition2]);
        $transition2->getId()->shouldBeCalled()->willReturn('transition-id-2');
        $transition->getId()->shouldBeCalled()->willReturn('transition-id');
        $transition->getInitialStates()->shouldBeCalled()->willReturn([]);

        $this->shouldThrow(
            new NotFoundHttpException(sprintf('Does not exist any initial status with %s id', 'initial-id'))
        )->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_deletes_initial_status(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusTransitionInterface $transition2,
        StatusInterface $initial,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition,
            'manage_status'
        );

        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $transition->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $issueRepository->findByWorkflow($workflow)->shouldBeCalled()->willReturn([$issue]);

        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getTransitions()->shouldBeCalled()->willReturn([$transition2]);
        $transition2->getId()->shouldBeCalled()->willReturn('transition-id-2');
        $transition->getId()->shouldBeCalled()->willReturn('transition-id');
        $transition->getInitialStates()->shouldBeCalled()->willReturn([$initial]);
        $initial->getId()->shouldBeCalled()->willReturn('initial-id');
        $transition->removeInitialState($initial)->shouldBeCalled()->willReturn($transition);
        $transitionRepository->save($transition)->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->deleteTransitionsInitialStatusAction('workflow-id', 'transition-id', 'initial-id')
            ->shouldReturn($response);
    }

    function it_does_not_get_end_status_because_the_workflow_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository
    )
    {
        $this->getWorkflowIfExist($container, $workflowRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with workflow-id id'))
            ->during('getTransitionsEndStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_get_end_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getTransitionsEndStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_get_end_status_because_the_status_transition_does_not_exist(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository
    )
    {
        $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $transitionRepository
        );

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with transition-id id'))
            ->during('getTransitionsEndStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_gets_end_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $status,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container,
            $workflowRepository,
            $workflow,
            $securityContext,
            $transitionRepository,
            $transition
        );

        $transition->getState()->shouldBeCalled()->willReturn($status);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getTransitionsEndStatusAction('workflow-id', 'transition-id')->shouldReturn($response);
    }
}

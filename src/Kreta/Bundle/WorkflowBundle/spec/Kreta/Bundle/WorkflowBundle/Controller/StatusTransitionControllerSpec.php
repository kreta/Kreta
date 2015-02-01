<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WorkflowBundle\Controller;

use Kreta\Bundle\WorkflowBundle\Form\Handler\Api\StatusTransitionHandler;
use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Kreta\Component\Workflow\Repository\StatusTransitionRepository;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class StatusTransitionControllerSpec.
 *
 * @package spec\Kreta\Bundle\WorkflowBundle\Controller
 */
class StatusTransitionControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Controller\StatusTransitionController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_does_not_get_status_transitions_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getTransitionsAction', ['workflow-id']);
    }

    function it_gets_status_transitions(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionInterface $transition
    )
    {
        $workflow = $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext);
        $workflow->getStatusTransitions()->shouldBeCalled()->willReturn([$transition]);

        $this->getTransitionsAction('workflow-id')->shouldReturn([$transition]);
    }

    function it_does_not_get_status_transition_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())
            ->during('getTransitionAction', ['workflow-id', 'status-transition-name']);
    }

    function it_gets_status_transition(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $transitionRepository, $transition
        );

        $this->getTransitionAction('workflow-id', 'transition-id')->shouldReturn($transition);
    }

    function it_does_not_post_status_transition_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('postTransitionsAction', ['workflow-id']);
    }

    function it_posts_status_transition(
        ContainerInterface $container,
        Request $request,
        StatusTransitionInterface $transition,
        StatusTransitionHandler $transitionHandler,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        Request $request
    )
    {
        $container->get('request')->shouldBeCalled()->willReturn($request);

        $workflow = $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status'
        );

        $container->get('kreta_workflow.form_handler.api.status_transition')
            ->shouldBeCalled()->willReturn($transitionHandler);
        $transitionHandler->processForm($request, null, ['workflow' => $workflow])
            ->shouldBeCalled()->willReturn($transition);

        $this->postTransitionsAction('workflow-id')->shouldReturn($transition);
    }

    function it_does_not_delete_status_transition_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedException())
            ->during('deleteTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_delete_status_transition_because_the_transition_is_in_use(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition, 'manage_status'
        );
        $transition->isInUse()->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(new ResourceInUseException())
            ->during('deleteTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_deletes_status_transition(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition, 'manage_status'
        );
        $transition->isInUse()->shouldBeCalled()->willReturn(false);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->remove($transition)->shouldBeCalled();

        $this->deleteTransitionAction('workflow-id', 'transition-id');
    }

    function it_does_not_get_initial_statuses_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())
            ->during('getTransitionsInitialStatusesAction', ['workflow-id', 'status-transition-id']);
    }

    function it_gets_initial_statuses(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $initial
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition
        );
        $transition->getInitialStates()->shouldBeCalled()->willReturn([$initial]);

        $this->getTransitionsInitialStatusesAction('workflow-id', 'transition-id')->shouldReturn([$initial]);
    }

    function it_does_not_get_initial_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())
            ->during('getTransitionsInitialStatusAction', ['workflow-id', 'status-transition-id', 'initial-id']);
    }

    function it_gets_initial_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $initial
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition
        );
        $transition->getInitialState('initial-id')->shouldBeCalled()->willReturn([$initial]);

        $this->getTransitionsInitialStatusAction('workflow-id', 'transition-id', 'initial-id')->shouldReturn([$initial]);
    }

    function it_does_not_post_initial_status_because_it_does_not_pass_initial_status_id(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        Request $request
    )
    {
        $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition, 'manage_status'
        );
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new BadRequestHttpException('The initial status should not be blank'))
            ->during('postTransitionsInitialStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_does_not_post_initial_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $context, 'manage_status', false);

        $this->shouldThrow(new AccessDeniedException())
            ->during('postTransitionsInitialStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_posts_initial_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $initial,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition, 'manage_status'
        );
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $request->get('initial_status')->shouldBeCalled()->willReturn('initial-status-id');
        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('initial-status-id', false)->shouldBeCalled()->willReturn($initial);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->persistInitialStatus($transition, $initial)->shouldBeCalled();
        $transition->getInitialStates()->shouldBeCalled()->willReturn([$initial]);

        $this->postTransitionsInitialStatusAction('workflow-id', 'transition-id')->shouldReturn([$initial]);
    }

    function it_does_not_delete_initial_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedException())
            ->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_does_not_delete_initial_status_because_transition_is_currently_in_use(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition, 'manage_status'
        );
        $transition->isInUse()->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(new ResourceInUseException())
            ->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_deletes_initial_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition, 'manage_status'
        );
        $transition->isInUse()->shouldBeCalled()->willReturn(false);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->removeInitialStatus($transition, 'initial-id')->shouldBeCalled()->willReturn($transition);

        $this->deleteTransitionsInitialStatusAction('workflow-id', 'transition-id', 'initial-id');
    }

    function it_does_not_get_end_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())
            ->during('getTransitionsEndStatusAction', ['workflow-id', 'transition-id']);
    }

    function it_gets_end_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $status
    )
    {
        $transition = $this->getTransitionIfAllowed(
            $container, $workflowRepository, $workflow, $context, $transitionRepository, $transition
        );
        $transition->getState()->shouldBeCalled()->willReturn($status);

        $this->getTransitionsEndStatusAction('workflow-id', 'transition-id')->shouldReturn($status);
    }

    protected function getTransitionIfAllowed(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusTransitionRepository $transitionRepository,
        $transition = null,
        $grant = 'view',
        $result = true
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $context, $grant, $result);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);

        return $transition;
    }

    protected function getWorkflowIfAllowedSpec(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_workflow.repository.workflow')->shouldBeCalled()->willReturn($workflowRepository);
        $workflowRepository->find('workflow-id', false)->shouldBeCalled()->willReturn($workflow);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $workflow)->shouldBeCalled()->willReturn($result);

        return $workflow;
    }
}

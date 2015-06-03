<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WorkflowBundle\Controller;

use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Kreta\Component\Workflow\Repository\StatusTransitionRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_status_transitions(
        Request $request,
        WorkflowInterface $workflow,
        StatusTransitionInterface $transition
    )
    {
        $request->get('workflow')->shouldBeCalled()->willReturn($workflow);
        $workflow->getStatusTransitions()->shouldBeCalled()->willReturn([$transition]);

        $this->getTransitionsAction($request, 'workflow-id')->shouldReturn([$transition]);
    }

    function it_gets_status_transition(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);

        $this->getTransitionAction('workflow-id', 'transition-id')->shouldReturn($transition);
    }

    function it_posts_status_transition(
        ContainerInterface $container,
        Request $request,
        StatusTransitionInterface $transition,
        Handler $handler,
        WorkflowInterface $workflow,
        Request $request
    )
    {
        $container->get('kreta_workflow.form_handler.status_transition')->shouldBeCalled()->willReturn($handler);
        $request->get('workflow')->shouldBeCalled()->willReturn($workflow);
        $handler->processForm($request, null, ['workflow' => $workflow])->shouldBeCalled()->willReturn($transition);

        $this->postTransitionsAction($request, 'workflow-id')->shouldReturn($transition);
    }

    function it_does_not_delete_status_transition_because_the_transition_is_in_use(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $transition->isInUse()->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(new ResourceInUseException())
            ->during('deleteTransitionAction', ['workflow-id', 'transition-id']);
    }

    function it_deletes_status_transition(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $transition->isInUse()->shouldBeCalled()->willReturn(false);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->remove($transition)->shouldBeCalled();

        $this->deleteTransitionAction('workflow-id', 'transition-id');
    }

    function it_gets_initial_statuses(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $initial
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $transition->getInitialStates()->shouldBeCalled()->willReturn([$initial]);

        $this->getTransitionsInitialStatusesAction('workflow-id', 'transition-id')->shouldReturn([$initial]);
    }

    function it_gets_initial_status(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $initial
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $transition->getInitialState('initial-id')->shouldBeCalled()->willReturn([$initial]);

        $this->getTransitionsInitialStatusAction('workflow-id', 'transition-id', 'initial-id')->shouldReturn([$initial]);
    }

    function it_does_not_post_initial_status_because_it_does_not_pass_initial_status_id(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        Request $request
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $request->get('initial_status')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new BadRequestHttpException('The initial status should not be blank'))
            ->during('postTransitionsInitialStatusAction', [$request, 'workflow-id', 'transition-id']);
    }

    function it_posts_initial_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $initial,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $request->get('initial_status')->shouldBeCalled()->willReturn('initial-status-id');
        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('initial-status-id', false)->shouldBeCalled()->willReturn($initial);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->persistInitialStatus($transition, $initial)->shouldBeCalled();
        $transition->getInitialStates()->shouldBeCalled()->willReturn([$initial]);

        $this->postTransitionsInitialStatusAction($request, 'workflow-id', 'transition-id')->shouldReturn([$initial]);
    }

    function it_does_not_delete_initial_status_because_transition_is_currently_in_use(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $transition->isInUse()->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(new ResourceInUseException())
            ->during('deleteTransitionsInitialStatusAction', ['workflow-id', 'transition-id', 'initial-id']);
    }

    function it_deletes_initial_status(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $transition->isInUse()->shouldBeCalled()->willReturn(false);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->removeInitialStatus($transition, 'initial-id')->shouldBeCalled()->willReturn($transition);

        $this->deleteTransitionsInitialStatusAction('workflow-id', 'transition-id', 'initial-id');
    }

    function it_gets_end_status(
        ContainerInterface $container,
        StatusTransitionRepository $transitionRepository,
        StatusTransitionInterface $transition,
        StatusInterface $status
    )
    {
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($transitionRepository);
        $transitionRepository->find('transition-id', false)->shouldBeCalled()->willReturn($transition);
        $transition->getState()->shouldBeCalled()->willReturn($status);

        $this->getTransitionsEndStatusAction('workflow-id', 'transition-id')->shouldReturn($status);
    }
}

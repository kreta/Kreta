<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Kreta\Component\Workflow\Model;

use Doctrine\ORM\NoResultException;
use Finite\StateMachine\StateMachineInterface;
use Kreta\Component\Core\Exception\CollectionMinLengthException;
use Kreta\Component\Core\Exception\ResourceAlreadyPersistException;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusTransitionSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class StatusTransitionSpec extends ObjectBehavior
{
    function let(StatusInterface $statusTo, WorkflowInterface $workflow)
    {
        $statusTo->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $this->beConstructedWith('Transition name', [], $statusTo);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Model\StatusTransition');
    }

    function it_implements_status_interface()
    {
        $this->shouldImplement('Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface');
    }

    function it_should_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_does_not_gets_initial_state()
    {
        $this->shouldThrow(new NoResultException())->during('getInitialState', ['initial-status-id']);
    }

    function it_gets_initial_state(StatusInterface $initialStatus, WorkflowInterface $workflow)
    {
        $initialStatus->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $initialStatus->getId()->shouldBeCalled()->willReturn('initial-status-id');
        $this->addInitialState($initialStatus);

        $this->getInitialState('initial-status-id')->shouldReturn($initialStatus);
    }

    function its_initial_status_is_not_a_status_instance($status)
    {
        $this->shouldThrow(
            new \InvalidArgumentException('Invalid argument passed, it is not an instance of StatusInterface')
        )->during('addInitialState', [$status]);
    }

    function its_initial_status_is_not_from_transition_workflow(StatusInterface $status, WorkflowInterface $workflow1)
    {
        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow1);
        $workflow1->getId()->shouldBeCalled()->willReturn('workflow-id');

        $this->shouldThrow(
            new \InvalidArgumentException('The initial status given is not from transition\'s workflow')
        )->during('addInitialState', [$status]);
    }

    function its_initial_status_is_already_added(StatusInterface $status, WorkflowInterface $workflow)
    {
        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $status->getId()->shouldBeCalled()->willReturn('status-id-1');
        $this->addInitialState($status);

        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $status->getId()->shouldBeCalled()->willReturn('status-id-1');

        $this->shouldThrow(new ResourceAlreadyPersistException())->during('addInitialState', [$status]);
    }

    function its_initials_state_are_mutable(
        StatusInterface $status,
        WorkflowInterface $workflow,
        StatusInterface $status2
    ) {
        $this->getInitialStates()->shouldHaveCount(0);

        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $status->getId()->shouldBeCalled()->willReturn('status-id-1');
        $this->addInitialState($status);

        $this->getInitialStates()->shouldHaveCount(1);

        $status2->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $status2->getId()->shouldBeCalled()->willReturn('status-id-2');
        $this->addInitialState($status2);

        $this->getInitialStates()->shouldHaveCount(2);
        $this->removeInitialState($status2);
        $this->getInitialStates()->shouldHaveCount(1);
    }

    function it_does_not_remove_the_initial_because_the_transition_must_have_at_least_one_initial_status(
        StatusInterface $status
    ) {
        $this->shouldThrow(new CollectionMinLengthException())->during('removeInitialState', [$status]);
    }

    function its_does_not_remove_the_initial_because_it_is_not_a_initial_of_transition(
        StatusInterface $status,
        WorkflowInterface $workflow,
        StatusInterface $status2,
        StatusInterface $status3
    ) {
        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $status->getId()->shouldBeCalled()->willReturn('status-id-1');
        $this->addInitialState($status);
        $status2->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $status2->getId()->shouldBeCalled()->willReturn('status-id-2');
        $this->addInitialState($status2);

        $this->shouldThrow(new NoResultException())->during('removeInitialState', [$status3]);
    }

    function it_should_transition_status_workflow_by_default(WorkflowInterface $workflow)
    {
        $this->getWorkflow()->shouldReturn($workflow);
    }

    function it_returns_false_because_the_transition_is_not_in_use_by_any_issue(
        WorkflowInterface $workflow,
        StatusInterface $status,
        ProjectInterface $project,
        IssueInterface $issue,
        StatusTransitionInterface $transition2
    ) {
        $this->getWorkflow()->shouldReturn($workflow);
        $workflow->getProjects()->shouldBeCalled()->willReturn([$project]);
        $project->getIssues()->shouldBeCalled()->willReturn([$issue]);

        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getTransitions()->shouldBeCalled()->willReturn([$transition2]);
        $transition2->getId()->shouldBeCalled()->willReturn('transition-id');
        $this->getId()->shouldReturn(null);

        $this->isInUse()->shouldReturn(false);
    }

    function it_returns_true_because_the_transition_is_in_use_by_any_issue(
        WorkflowInterface $workflow,
        StatusInterface $status,
        ProjectInterface $project,
        IssueInterface $issue,
        StatusTransitionInterface $transition2
    ) {
        $this->getWorkflow()->shouldReturn($workflow);
        $workflow->getProjects()->shouldBeCalled()->willReturn([$project]);
        $project->getIssues()->shouldBeCalled()->willReturn([$issue]);

        $issue->getStatus()->shouldBeCalled()->willReturn($status);
        $status->getTransitions()->shouldBeCalled()->willReturn([$transition2]);
        $transition2->getId()->shouldBeCalled()->willReturn(null);
        $this->getId()->shouldReturn(null);

        $this->isInUse()->shouldReturn(true);
    }

    function it_is_valid_state()
    {
        $this->isValidState()->shouldReturn(true);
    }

    function it_is_not_valid_state_because_the_state_is_in_initial_states_array(
        StatusInterface $initial,
        WorkflowInterface $workflow,
        StatusInterface $statusTo
    ) {
        $initial->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getId()->shouldBeCalled()->willReturn('workflow-id');
        $initial->getId()->shouldBeCalled()->willReturn('status-id');
        $this->addInitialState($initial);

        $statusTo->getId()->shouldBeCalled()->willReturn('status-id');

        $this->isValidState()->shouldReturn(false);
    }

    function it_gets_initial_states()
    {
        $this->getInitialStates()->shouldBeArray();
    }

    function it_gets_state(StatusInterface $statusTo)
    {
        $this->getState()->shouldReturn($statusTo);
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('Transition name');
        $this->__toString()->shouldReturn('Transition name');
    }

    function it_gets_a_null_in_guard_and_process_methods(StateMachineInterface $stateMachine)
    {
        $this->process($stateMachine)->shouldReturn(null);
        $this->getGuard()->shouldReturn(null);
    }
}

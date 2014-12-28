<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Workflow\Model;

use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusTransitionSpec.
 *
 * @package spec\Kreta\Component\Workflow\Model
 */
class StatusTransitionSpec extends ObjectBehavior
{
    function let(StatusInterface $statusTo)
    {
        $this->beConstructedWith('Transition name', [], $statusTo);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Model\StatusTransition');
    }

    function it_extends_finite_state()
    {
        $this->shouldHaveType('Finite\Transition\Transition');
    }

    function it_implements_status_interface()
    {
        $this->shouldImplement('Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface');
    }

    function it_should_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_initials_state_are_mutable(StatusInterface $status, StatusInterface $status2, StatusInterface $status3)
    {
        $this->getInitialStates()->shouldHaveCount(0);

        $this->addInitialState($status);

        $this->getInitialStates()->shouldHaveCount(1);

        $this->addInitialState($status2);

        $this->getInitialStates()->shouldHaveCount(1);

        $status3->getId()->shouldBeCalled()->willReturn('st-id-3');
        $this->addInitialState($status3);

        $this->getInitialStates()->shouldHaveCount(2);

        $this->removeInitialState($status);

        $this->getInitialStates()->shouldHaveCount(1);
    }

    function it_does_not_add_the_initial_because_the_status_is_not_status_object()
    {
        $this->shouldThrow(
            new \InvalidArgumentException('Invalid argument passed, it is not an instance of StatusInterface')
        )->during('addInitialState', ['not-status-object']);
    }

    function it_does_not_remove_the_initial_because_the_transition_must_have_at_least_one_initial_status(
        StatusInterface $status
    )
    {
        $this->shouldThrow(
            new \Exception('Impossible to remove. The transition must have at least one initial status')
        )->during('removeInitialState', [$status]);
    }

    function its_name_is_mutable()
    {
        $this->setName('Dummy name')->shouldReturn($this);
        $this->getName()->shouldReturn('Dummy name');
    }

    function its_state_is_mutable(StatusInterface $status)
    {
        $this->setState($status)->shouldReturn($this);
        $this->getState()->shouldReturn($status);
    }

    function it_should_not_have_workflow_by_default()
    {
        $this->getWorkflow()->shouldReturn(null);
    }

    function it_is_valid_state()
    {
        $this->isValidState()->shouldReturn(true);
    }

    function it_is_valid_state_because_the_state_is_in_initial_states_array(StatusInterface $initial)
    {
        $this->addInitialState($initial);
        $this->isValidState()->shouldReturn(false);
    }
}

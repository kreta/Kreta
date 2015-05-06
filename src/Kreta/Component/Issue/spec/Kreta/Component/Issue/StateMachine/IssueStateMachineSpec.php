<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\StateMachine;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class IssueStateMachineSpec.
 *
 * @package spec\Kreta\Component\Issue\StateMachine
 */
class IssueStateMachineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\StateMachine\IssueStateMachine');
    }

    function it_extends_state_machine()
    {
        $this->shouldHaveType('Finite\StateMachine\StateMachine');
    }

    function it_loads(
        IssueInterface $issue,
        StatusInterface $status,
        StatusInterface $status2,
        StatusTransitionInterface $transition
    )
    {
        $status->getName()->shouldBeCalled()->willReturn('Open');
        $status->getType()->shouldBeCalled()->willReturn('initial');

        $status2->getName()->shouldBeCalled()->willReturn('In progress');
        $status2->getType()->shouldBeCalled()->willReturn('normal');

        $transition->getInitialStates()->shouldBeCalled()->willReturn([$status]);
        $transition->getName()->shouldBeCalled()->willReturn('Start progress');
        $transition->getState()->shouldBeCalled()->willReturn($status2);

        $this->load($issue, [$status, $status2], [$transition])
            ->shouldReturnAnInstanceOf('Kreta\Component\Issue\StateMachine\IssueStateMachine');
    }
}

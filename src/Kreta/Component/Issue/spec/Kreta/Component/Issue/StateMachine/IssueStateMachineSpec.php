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

namespace spec\Kreta\Component\Issue\StateMachine;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssueStateMachineSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
    ) {
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

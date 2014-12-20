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
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class StatusTransitionSpec.
 *
 * @package spec\Kreta\Component\Workflow\Model
 */
class StatusTransitionSpec extends ObjectBehavior
{
    function let(StatusInterface $statusFrom, StatusInterface $statusTo)
    {
        $this->beConstructedWith('Transition name', [$statusFrom], $statusTo);
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

    function its_id_is_mutable()
    {
        $this->setId('2222')->shouldReturn($this);
        $this->getId()->shouldReturn('2222');
    }

    function its_name_is_mutable()
    {
        $this->getName()->shouldReturn('Transition name');

        $this->setName('New transition name')->shouldReturn($this);
        $this->getName()->shouldReturn('New transition name');
    }

    function its_workflow_is_mutable(WorkflowInterface $workflow)
    {
        $this->setWorkflow($workflow)->shouldReturn($this);
        $this->getWorkflow()->shouldReturn($workflow);
    }
}

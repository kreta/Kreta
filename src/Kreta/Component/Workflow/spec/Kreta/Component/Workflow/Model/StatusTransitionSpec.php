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

    function it_should_not_have_workflow_by_default()
    {
        $this->getWorkflow()->shouldReturn(null);
    }
}

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Model;

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class StatusTransitionSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class StatusTransitionSpec extends ObjectBehavior
{
    function let(StatusInterface $statusFrom, StatusInterface $statusTo)
    {
        $this->beConstructedWith('Transition name', [$statusFrom], $statusTo);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\StatusTransition');
    }

    function it_extends_finite_state()
    {
        $this->shouldHaveType('Finite\Transition\Transition');
    }

    function it_implements_status_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\StatusTransitionInterface');
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

    function its_project_is_mutable(ProjectInterface $project)
    {
        $this->setProject($project)->shouldReturn($this);
        $this->getProject()->shouldReturn($project);
    }
}

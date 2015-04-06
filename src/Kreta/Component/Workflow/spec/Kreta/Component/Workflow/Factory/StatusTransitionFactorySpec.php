<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Workflow\Factory;

use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusTransitionFactorySpec.
 *
 * @package spec\Kreta\Component\Workflow\Factory
 */
class StatusTransitionFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Workflow\Model\StatusTransition');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Factory\StatusTransitionFactory');
    }

    function it_creates_a_status(StatusInterface $status)
    {
        $this->create(
            'Start progress', $status, [Argument::type('Kreta\Component\Workflow\Model\StatusTransition')]
        )->shouldReturnAnInstanceOf('Kreta\Component\Workflow\Model\StatusTransition');
    }
}

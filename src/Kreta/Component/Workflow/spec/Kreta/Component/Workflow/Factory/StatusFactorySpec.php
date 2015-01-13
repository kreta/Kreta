<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Workflow\Factory;

use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusFactorySpec.
 *
 * @package spec\Kreta\Component\Workflow\Factory
 */
class StatusFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Workflow\Model\Status');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Factory\StatusFactory');
    }

    function it_creates_a_status(WorkflowInterface $workflow)
    {
        $this->create('Open', $workflow)->shouldReturnAnInstanceOf('Kreta\Component\Workflow\Model\Status');
    }
}

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

use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class WorkflowFactorySpec.
 *
 * @package spec\Kreta\Component\Workflow\Factory
 */
class WorkflowFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Workflow\Model\Workflow');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Workflow\Factory\WorkflowFactory');
    }

    function it_creates_a_workflow(UserInterface $user)
    {
        $this->create('Open', $user, true)->shouldReturnAnInstanceOf('Kreta\Component\Workflow\Model\Workflow');
    }
}

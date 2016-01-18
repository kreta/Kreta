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

namespace spec\Kreta\Component\Workflow\Factory;

use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class WorkflowFactorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

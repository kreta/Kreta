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

use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StatusTransitionFactorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

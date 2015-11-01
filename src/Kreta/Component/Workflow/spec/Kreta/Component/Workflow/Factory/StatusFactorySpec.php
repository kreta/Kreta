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

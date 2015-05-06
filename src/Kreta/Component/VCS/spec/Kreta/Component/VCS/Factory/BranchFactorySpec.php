<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class BranchFactorySpec.
 *
 * @package spec\Kreta\Component\VCS\Factory
 */
class BranchFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\VCS\Model\Branch');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Factory\BranchFactory');
    }

    function it_creates_branch_model()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\Component\VCS\Model\Branch');
    }
}

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

namespace spec\Kreta\Component\Issue\Factory;

use PhpSpec\ObjectBehavior;

/**
 * Class ResolutionFactorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ResolutionFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Issue\Model\Resolution');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Factory\ResolutionFactory');
    }

    function it_creates_a_resolution()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\Component\Issue\Model\Resolution');
    }
}

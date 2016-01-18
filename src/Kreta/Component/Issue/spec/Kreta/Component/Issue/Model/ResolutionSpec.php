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

namespace spec\Kreta\Component\Issue\Model;

use PhpSpec\ObjectBehavior;

/**
 * Class ResolutionSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ResolutionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Model\Resolution');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_status_interface()
    {
        $this->shouldImplement('Kreta\Component\Issue\Model\Interfaces\ResolutionInterface');
    }

    function its_description_is_mutable()
    {
        $this->setDescription('This is a dummy description of resolution')->shouldReturn($this);
        $this->getDescription()->shouldReturn('This is a dummy description of resolution');
    }
}

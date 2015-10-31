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

namespace spec\Kreta\Component\Core\Model\Abstracts;

use PhpSpec\ObjectBehavior;

/**
 * Class AbstractModelSpec.
 *
 * @package spec\Kreta\Component\Core\Model\Abstracts
 */
class AbstractModelSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('Kreta\Component\Core\Stubs\Model\AbstractModelStub');
    }

    function it_does_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_id_is_mutable()
    {
        $this->setId('dummy-id')->shouldReturn($this);
        $this->getId()->shouldReturn('dummy-id');
    }

    function its_toString_returns_null_if_its_id_is_null()
    {
        $this->__toString()->shouldReturn(null);
    }

    function its_toString_returns_a_string()
    {
        $this->setId('dummy-id')->shouldReturn($this);
        $this->__toString()->shouldReturn('dummy-id');
    }
}

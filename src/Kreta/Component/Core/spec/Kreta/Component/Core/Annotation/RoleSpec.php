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

namespace spec\Kreta\Component\Core\Annotation;

use PhpSpec\ObjectBehavior;

/**
 * Class RoleSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class RoleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType('Kreta\Component\Core\Annotation\Role');
    }

    function it_gets_rols_when_the_given_value_is_empty()
    {
        $this->beConstructedWith([]);
        $this->getRoles()->shouldReturn([]);
    }

    function it_gets_roles_when_the_given_value_is_scalar()
    {
        $this->beConstructedWith(['value' => 'admin']);
        $this->getRoles()->shouldReturn(['admin']);
    }

    function it_gets_roles_when_the_given_value_is_an_array()
    {
        $this->beConstructedWith(['value' => ['admin', 'marketing']]);
        $this->getRoles()->shouldReturn(['admin', 'marketing']);
    }
}

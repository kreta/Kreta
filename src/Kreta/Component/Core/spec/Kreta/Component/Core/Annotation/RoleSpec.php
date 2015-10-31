<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Annotation;

use PhpSpec\ObjectBehavior;

/**
 * Class RoleSpec.
 *
 * @package spec\Kreta\Component\Core\Annotation
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

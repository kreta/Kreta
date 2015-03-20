<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Form\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InvalidFormExceptionSpec.
 *
 * @package spec\Kreta\Component\Core\Form\Exception
 */
class InvalidFormExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Form\Exception\InvalidFormException');
    }

    function it_extends_exception()
    {
        $this->shouldHaveType('\Exception');
    }

    function it_gets_form_errors_without_errors()
    {
        $this->getFormErrors()->shouldReturn([]);
    }
    
    function it_gets_form_errors()
    {
        $this->beConstructedWith(
            ['name' => ['This value should not be blank', 'An object with identical name is already exists']]
        );
        
        $this->getFormErrors()->shouldReturn(
            ['name' => ['This value should not be blank', 'An object with identical name is already exists']]
        );
    }
}

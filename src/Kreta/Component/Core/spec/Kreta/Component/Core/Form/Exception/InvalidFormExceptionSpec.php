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

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

namespace Spec\Kreta\SharedKernel\Serialization;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Serialization\ClassNameDoesNotExistException;
use PhpSpec\ObjectBehavior;

class ClassNameDoesNotExistExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('class-name');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ClassNameDoesNotExistException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('Does not exist any "class-name" class name');
    }
}

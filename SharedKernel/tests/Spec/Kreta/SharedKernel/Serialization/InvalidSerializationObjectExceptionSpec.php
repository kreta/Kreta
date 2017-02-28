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

declare(strict_types=1);

namespace Spec\Kreta\SharedKernel\Serialization;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Serialization\InvalidSerializationObjectException;
use PhpSpec\ObjectBehavior;

class InvalidSerializationObjectExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('expected-instance', 'given-instance');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidSerializationObjectException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('Expected an instance of "expected-instance", "given-instance" given');
    }
}

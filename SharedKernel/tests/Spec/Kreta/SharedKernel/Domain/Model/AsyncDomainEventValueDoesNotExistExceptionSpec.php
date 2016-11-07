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

namespace Spec\Kreta\SharedKernel\Domain\Model;

use Kreta\SharedKernel\Domain\Model\AsyncDomainEventValueDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\Exception;
use PhpSpec\ObjectBehavior;

class AsyncDomainEventValueDoesNotExistExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('value-key');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AsyncDomainEventValueDoesNotExistException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('Does not exist any "value-key" key inside values array');
    }
}

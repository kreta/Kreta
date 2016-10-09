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

namespace Spec\Kreta\SharedKernel\Domain\Model\Identity;

use Kreta\SharedKernel\Domain\Model\Identity\EmailAddressInvalidException;
use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class EmailAddressInvalidExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EmailAddressInvalidException::class);
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}

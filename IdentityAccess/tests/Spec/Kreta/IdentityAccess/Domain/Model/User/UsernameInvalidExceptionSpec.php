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

namespace Spec\Kreta\IdentityAccess\Domain\Model\User;

use Kreta\IdentityAccess\Domain\Model\User\UsernameInvalidException;
use Kreta\SharedKernel\Domain\Model\Exception;
use PhpSpec\ObjectBehavior;

class UsernameInvalidExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            '%#not valid Username'
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UsernameInvalidException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('The given "%#not valid Username" username is not valid');
    }
}

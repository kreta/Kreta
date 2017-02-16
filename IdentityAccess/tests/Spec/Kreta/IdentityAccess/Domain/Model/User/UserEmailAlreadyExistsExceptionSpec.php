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

namespace Spec\Kreta\IdentityAccess\Domain\Model\User;

use BenGorUser\User\Domain\Model\UserEmail;
use Kreta\IdentityAccess\Domain\Model\User\UserEmailAlreadyExistsException;
use Kreta\SharedKernel\Domain\Model\Exception;
use PhpSpec\ObjectBehavior;

class UserEmailAlreadyExistsExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new UserEmail('info@kreta.io')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserEmailAlreadyExistsException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('The given "info@kreta.io" email is already in use by other user');
    }
}

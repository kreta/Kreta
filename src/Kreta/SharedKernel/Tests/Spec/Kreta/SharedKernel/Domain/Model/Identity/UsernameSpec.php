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

use Kreta\SharedKernel\Domain\Model\Identity\Username;
use Kreta\SharedKernel\Domain\Model\Identity\UsernameInvalidException;
use PhpSpec\ObjectBehavior;

class UsernameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('kretausername');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Username::class);
    }

    function it_does_not_allow_empty_username()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(UsernameInvalidException::class)->duringInstantiation();
    }

    function it_returns_username()
    {
        $this->username()->shouldReturn('kretausername');
        $this->__toString()->shouldReturn('kretausername');
    }
}

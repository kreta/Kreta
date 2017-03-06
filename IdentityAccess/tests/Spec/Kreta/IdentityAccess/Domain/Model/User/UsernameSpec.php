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

use BenGorUser\User\Domain\Model\UserEmail;
use Kreta\IdentityAccess\Domain\Model\User\Username;
use Kreta\IdentityAccess\Domain\Model\User\UsernameInvalidException;
use PhpSpec\ObjectBehavior;

class UsernameSpec extends ObjectBehavior
{
    function it_creates_from_email()
    {
        $email = new UserEmail('info@kreta.io');
        $this->beConstructedFromEmail($email);
        $this->shouldHaveType(Username::class);

        $this->username()->shouldContain('info');
        $this->__toString()->shouldContain('info');
    }

    function it_creates()
    {
        $this->beConstructedWIth('kreta');
        $this->username()->shouldReturn('kreta');
        $this->__toString()->shouldReturn('kreta');
    }

    function it_does_not_creates_with_invalid_username()
    {
        $this->beConstructedWith('kreta=#,');
        $this->shouldThrow(UsernameInvalidException::class)->duringInstantiation();
    }

    function it_does_not_creates_with_less_than_2_length()
    {
        $this->beConstructedWith('k');
        $this->shouldThrow(UsernameInvalidException::class)->duringInstantiation();
    }

    function it_does_not_creates_with_more_than_20_length()
    {
        $this->beConstructedWith('sdskfhsdufhsduifisudfhisudfhisufdhid');
        $this->shouldThrow(UsernameInvalidException::class)->duringInstantiation();
    }
}

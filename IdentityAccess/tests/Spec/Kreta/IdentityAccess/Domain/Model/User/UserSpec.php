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

use BenGorUser\User\Domain\Model\User as BaseUser;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserPassword;
use BenGorUser\User\Domain\Model\UserRole;
use BenGorUser\User\Infrastructure\Security\DummyUserPasswordEncoder;
use Kreta\IdentityAccess\Domain\Model\User\FullName;
use Kreta\IdentityAccess\Domain\Model\User\User;
use Kreta\IdentityAccess\Domain\Model\User\Username;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $encoder = new DummyUserPasswordEncoder('encodedPassword');

        $this->beConstructedSignUp(
            new UserId(),
            new UserEmail('test@test.com'),
            UserPassword::fromPlain('strongpassword', $encoder),
            [new UserRole('ROLE_USER')]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
        $this->shouldHaveType(BaseUser::class);
    }

    function it_gets_username()
    {
        $this->username()->shouldReturnAnInstanceOf(Username::class);
    }

    function it_gets_full_name()
    {
        $this->fullName()->shouldReturn(null);
    }

    function it_edits_profile(
        Username $username,
        FullName $fullName
    ) {
        $email = new UserEmail('test@test.com');

        $this->fullName()->shouldReturn(null);

        $this->editProfile($email, $username, $fullName);

        $fullName->fullName()->shouldBeCalled()->willReturn('Kreta name');

        $this->fullName()->shouldReturn($fullName);
        $this->username()->shouldReturn($username);
    }
}

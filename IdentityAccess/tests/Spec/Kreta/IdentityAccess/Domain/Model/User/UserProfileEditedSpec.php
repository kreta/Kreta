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
use BenGorUser\User\Domain\Model\UserId;
use Kreta\IdentityAccess\Domain\Model\User\UserProfileEdited;
use PhpSpec\ObjectBehavior;

class UserProfileEditedSpec extends ObjectBehavior
{
    function it_creates_event()
    {
        $id = new UserId('user-id');
        $email = new UserEmail('bengor@user.com');
        $this->beConstructedWith($id, $email);
        $this->shouldHaveType(UserProfileEdited::class);

        $this->id()->shouldReturn($id);
        $this->email()->shouldReturn($email);
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
    }
}

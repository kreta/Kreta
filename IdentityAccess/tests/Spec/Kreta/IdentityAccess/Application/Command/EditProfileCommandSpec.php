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

namespace Spec\Kreta\IdentityAccess\Application\Command;

use Kreta\IdentityAccess\Application\Command\EditProfileCommand;
use PhpSpec\ObjectBehavior;

class EditProfileCommandSpec extends ObjectBehavior
{
    function it_creates_a_command()
    {
        $this->beConstructedWith('user-id', 'user@user.net', 'kreta-username', 'kreta', 'lastname');
        $this->shouldHaveType(EditProfileCommand::class);

        $this->id()->shouldReturn('user-id');
        $this->email()->shouldReturn('user@user.net');
        $this->username()->shouldReturn('kreta-username');
        $this->firstName()->shouldReturn('kreta');
        $this->lastName()->shouldReturn('lastname');
    }
}

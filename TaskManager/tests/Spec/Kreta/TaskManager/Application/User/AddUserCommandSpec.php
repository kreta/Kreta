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

namespace Spec\Kreta\TaskManager\Application\User;

use Kreta\TaskManager\Application\User\AddUserCommand;
use PhpSpec\ObjectBehavior;

class AddUserCommandSpec extends ObjectBehavior
{
    function it_can_be_created()
    {
        $this->beConstructedWith('user-id');
        $this->shouldHaveType(AddUserCommand::class);
        $this->userId()->shouldReturn('user-id');
    }
}

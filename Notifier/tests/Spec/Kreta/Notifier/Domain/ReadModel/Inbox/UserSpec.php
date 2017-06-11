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

namespace Spec\Kreta\Notifier\Domain\ReadModel\Inbox;

use Kreta\Notifier\Domain\ReadModel\Inbox\User;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function it_can_be_built()
    {
        $this->beConstructedWith('user-id');
        $this->shouldHaveType(User::class);
        $this->shouldImplement(\JsonSerializable::class);
        $this->jsonSerialize()->shouldReturn(['id' => 'user-id']);
    }

    function it_can_be_built_from_array()
    {
        $this->beConstructedFromArray(['id' => 'user-id']);
        $this->jsonSerialize()->shouldReturn(['id' => 'user-id']);
    }
}

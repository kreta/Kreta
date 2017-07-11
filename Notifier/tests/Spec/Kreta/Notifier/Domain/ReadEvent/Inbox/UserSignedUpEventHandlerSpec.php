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

namespace Spec\Kreta\Notifier\Domain\ReadEvent\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserSignedUp;
use Kreta\Notifier\Domain\ReadEvent\Inbox\UserSignedUpEventHandler;
use Kreta\Notifier\Domain\ReadModel\Inbox\User;
use Kreta\Notifier\Domain\ReadModel\Inbox\UserView;
use Kreta\SharedKernel\Domain\ReadEvent\EventHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSignedUpEventHandlerSpec extends ObjectBehavior
{
    function let(UserView $view)
    {
        $this->beConstructedWith($view);
    }

    function it_can_be_handle(UserSignedUp $event, UserView $view, UserId $userId)
    {
        $this->shouldHaveType(UserSignedUpEventHandler::class);
        $this->shouldImplement(EventHandler::class);

        $event->userId()->shouldBeCalled()->willReturn($userId);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
        $view->save(Argument::type(User::class))->shouldBeCalled();

        $this->handle($event);
    }

    function it_subscribes_to()
    {
        $this->isSubscribeTo()->shouldReturn(UserSignedUp::class);
    }
}

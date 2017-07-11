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

namespace Spec\Kreta\Notifier\Domain\Event\Inbox;

use Kreta\Notifier\Application\Inbox\SignUpUserCommand;
use Kreta\Notifier\Domain\Event\Inbox\UserSignedUpSubscriber;
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Domain\Event\AsyncEventSubscriber;
use Kreta\SharedKernel\Domain\Model\AsyncDomainEvent;
use Kreta\SharedKernel\Domain\Model\AsyncDomainEventValueDoesNotExistException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSignedUpSubscriberSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserSignedUpSubscriber::class);
        $this->shouldHaveType(AsyncEventSubscriber::class);
    }

    function it_can_be_handle(AsyncDomainEvent $event, CommandBus $commandBus)
    {
        $event->values()->shouldBeCalled()->willReturn([
            'userId' => 'user-id',
        ]);
        $commandBus->handle(Argument::type(SignUpUserCommand::class))->shouldBeCalled();
        $this->handle($event);
    }

    function it_cannot_be_handle_when_values_does_not_contain_user_id(AsyncDomainEvent $event)
    {
        $event->values()->shouldBeCalled()->willReturn([]);
        $this->shouldThrow(AsyncDomainEventValueDoesNotExistException::class)->duringHandle($event);
    }
}

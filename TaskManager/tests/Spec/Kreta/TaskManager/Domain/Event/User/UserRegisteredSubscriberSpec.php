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

namespace Spec\Kreta\TaskManager\Domain\Event\User;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Domain\Event\AsyncEventSubscriber;
use Kreta\SharedKernel\Domain\Model\AsyncDomainEvent;
use Kreta\SharedKernel\Domain\Model\AsyncDomainEventValueDoesNotExistException;
use Kreta\TaskManager\Application\Command\User\AddUserCommand;
use Kreta\TaskManager\Domain\Event\User\UserRegisteredSubscriber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserRegisteredSubscriberSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserRegisteredSubscriber::class);
        $this->shouldHaveType(AsyncEventSubscriber::class);
    }

    function it_can_be_handle(AsyncDomainEvent $event, CommandBus $commandBus)
    {
        $event->values()->shouldBeCalled()->willReturn([
            'userId' => 'user-id',
        ]);
        $commandBus->handle(Argument::type(AddUserCommand::class))->shouldBeCalled();
        $this->handle($event);
    }

    function it_cannot_be_handle_when_values_does_not_contain_user_id(AsyncDomainEvent $event)
    {
        $event->values()->shouldBeCalled()->willReturn([]);
        $this->shouldThrow(AsyncDomainEventValueDoesNotExistException::class)->duringHandle($event);
    }
}

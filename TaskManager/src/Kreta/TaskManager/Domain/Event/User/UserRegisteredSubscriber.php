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

namespace Kreta\TaskManager\Domain\Event\User;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Domain\Event\AsyncEventSubscriber;
use Kreta\SharedKernel\Domain\Model\AsyncDomainEvent;
use Kreta\SharedKernel\Domain\Model\AsyncDomainEventValueDoesNotExistException;
use Kreta\TaskManager\Application\Command\User\AddUserCommand;

class UserRegisteredSubscriber implements AsyncEventSubscriber
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(AsyncDomainEvent $event) : void
    {
        if (!isset($event->values()['userId'])) {
            throw new AsyncDomainEventValueDoesNotExistException('userId');
        }

        $this->commandBus->handle(
            new AddUserCommand(
                $event->values()['userId']
            )
        );
    }
}

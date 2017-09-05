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

namespace Kreta\TaskManager\Tests\Behat\Context\Domain\User;

use Behat\Behat\Context\Context;
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\TaskManager\Application\Command\User\AddUserCommand;

class UserContext implements Context
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Given :userId as organization creator id to create the organization
     */
    public function addUserOfId(string $userId) : void
    {
        $this->commandBus->handle(
            new AddUserCommand($userId)
        );
    }
}

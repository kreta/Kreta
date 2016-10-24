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

namespace Spec\Kreta\SharedKernel\Infrastructure\Application\SimpleBus;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Infrastructure\Application\SimpleBus\SimpleBusCommandBus;
use Kreta\TaskManager\Application\Organization\CreateOrganizationCommand;
use PhpSpec\ObjectBehavior;
use SimpleBus\Message\Bus\MessageBus;

class SimpleBusCommandBusSpec extends ObjectBehavior
{
    function let(MessageBus $messageBus)
    {
        $this->beConstructedWith($messageBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SimpleBusCommandBus::class);
        $this->shouldImplement(CommandBus::class);
    }

    function it_handles_a_command(MessageBus $messageBus, CreateOrganizationCommand $command)
    {
        $messageBus->handle($command)->shouldBeCalled();

        $this->handle($command);
    }
}

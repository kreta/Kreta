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

namespace Kreta\Notifier\Infrastructure\Symfony\Command;

use Kreta\Notifier\Application\Command\Notification\PublishNotificationCommand as ApplicationPublishNotificationCommand;
use Kreta\SharedKernel\Application\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PublishNotificationCommand extends Command
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct('kreta:notifier:notification:publish');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $body = 'The notification body';
        $userId = 'user-id';

        $this->commandBus->handle(
            new ApplicationPublishNotificationCommand(
                $body,
                $userId
            )
        );

        $output->writeln('Published the notification');
    }
}

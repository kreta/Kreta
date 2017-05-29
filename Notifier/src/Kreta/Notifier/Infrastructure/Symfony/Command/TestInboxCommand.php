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

use Kreta\Notifier\Application\Command\Inbox\ReadNotificationCommand;
use Kreta\Notifier\Application\Command\Inbox\ReceiveNotificationCommand;
use Kreta\Notifier\Application\Command\Inbox\SignUpUserCommand;
use Kreta\Notifier\Application\Command\Inbox\UnreadNotificationCommand;
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Domain\Model\Identity\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestInboxCommand extends Command
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct('kreta:notifier:inbox:test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $body = 'The notification body';

        for ($i = 0; $i < 2; ++$i) {
            $userId = Uuid::generate();

            $signUpUserCommand = new SignUpUserCommand($userId);
            $this->commandBus->handle($signUpUserCommand);

            $output->writeln('Signed up the user ' . $i);

            for ($j = 0; $j < 15; ++$j) {
                $notificationId = Uuid::generate();

                $receiveNotificationCommand = new ReceiveNotificationCommand($body, $userId, $notificationId);
                $this->commandBus->handle($receiveNotificationCommand);

                $output->writeln('Received the notification ' . $j);

                $readNotificationCommand = new ReadNotificationCommand($notificationId, $userId);
                $this->commandBus->handle($readNotificationCommand);

                $output->writeln('Read the notification ' . $j);

                if ($j % 2 === 0) {
                    $unreadNotificationCommand = new UnreadNotificationCommand($notificationId, $userId);
                    $this->commandBus->handle($unreadNotificationCommand);

                    $output->writeln('Unread the notification ' . $j);
                }
            }
        }
    }
}

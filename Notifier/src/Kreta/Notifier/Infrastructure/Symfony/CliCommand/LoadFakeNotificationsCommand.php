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

namespace Kreta\Notifier\Infrastructure\Symfony\CliCommand;

use Kreta\Notifier\Application\Inbox\Notification\MarkAsReadNotificationCommand;
use Kreta\Notifier\Application\Inbox\Notification\MarkAsUnreadNotificationCommand;
use Kreta\Notifier\Application\Inbox\Notification\PublishNotificationCommand;
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Infrastructure\Persistence\Fake\FakeDataCapabilities;
use Kreta\SharedKernel\Infrastructure\Persistence\Fake\UserFakeData;
use Predis\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFakeNotificationsCommand extends Command
{
    use FakeDataCapabilities;

    private $commandBus;
    private $redis;
    private $userFakeData;

    public function __construct(CommandBus $commandBus, Client $redis, UserFakeData $userFakeData)
    {
        $this->commandBus = $commandBus;
        $this->redis = $redis;
        $this->userFakeData = $userFakeData;

        parent::__construct('kreta:notifier:inbox:notification:load');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->purgeDatabases();

        $i = 0;
        while ($i < $this->amount()) {
            $userId = $this->userFakeData->userOfIndex($i);
            $notificationId = $this->ids()[$i];
            $body = 'The notification body ' . $i;

            $receiveNotificationCommand = new PublishNotificationCommand($body, $userId, $notificationId);
            $this->commandBus->handle($receiveNotificationCommand);

            $readNotificationCommand = new MarkAsReadNotificationCommand($notificationId, $userId);
            $this->commandBus->handle($readNotificationCommand);

            if ($i % 2 === 0) {
                $unreadNotificationCommand = new MarkAsUnreadNotificationCommand($notificationId, $userId);
                $this->commandBus->handle($unreadNotificationCommand);
            }
            ++$i;
        }

        $output->writeln('The fake notifications are successfully loaded');
    }

    private function purgeDatabases() : void
    {
        $i = 0;
        while ($i < $this->amount()) {
            $this->redis->del($this->type() . '-' . $this->dataOfIndex($i));
            ++$i;
        }
    }

    protected function type() : string
    {
        return 'notification';
    }

    protected function dataDir() : string
    {
        return __DIR__ . '/../../Persistence/Fake';
    }
}

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

use Kreta\Notifier\Application\Inbox\SignUpUserCommand;
use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Infrastructure\Persistence\Fake\UserFakeData;
use Predis\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFakeUsersCommand extends Command
{
    private $commandBus;
    private $redis;
    private $userFakeData;

    public function __construct(CommandBus $commandBus, Client $redis, UserFakeData $userFakeData)
    {
        $this->commandBus = $commandBus;
        $this->redis = $redis;
        $this->userFakeData = $userFakeData;

        parent::__construct('kreta:notifier:inbox:user:load');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->purgeDatabases();

        $i = 0;
        while ($i < $this->userFakeData->amount()) {
            $this->commandBus->handle(
                new SignUpUserCommand(
                    $this->userFakeData->userOfIndex($i)
                )
            );
            ++$i;
        }

        $output->writeln('The fake users are successfully loaded');
    }

    private function purgeDatabases() : void
    {
        $i = 0;
        while ($i < $this->userFakeData->amount()) {
            $this->redis->del('user-events: ' . $this->userFakeData->userOfIndex($i));
            ++$i;
        }
    }
}

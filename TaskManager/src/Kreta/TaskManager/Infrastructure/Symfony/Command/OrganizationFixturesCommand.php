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

namespace Kreta\TaskManager\Infrastructure\Symfony\Command;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Domain\Model\Identity\Uuid;
use Kreta\TaskManager\Application\Command\Organization\AddOrganizationMemberToOrganizationCommand;
use Kreta\TaskManager\Application\Command\Organization\CreateOrganizationCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrganizationFixturesCommand extends Command
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct('kreta:task-manager:fixtures:organizations');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $amount = 30;
        $output->writeln('');
        $output->writeln('Loading organizations...');
        $progress = new ProgressBar($output, $amount);
        $progress->start();
        $i = 0;

        $memberIds = [];
        while ($i < $amount) {
            $ownerId = UserFixturesCommand::USER_IDS[array_rand(UserFixturesCommand::USER_IDS)];
            if ($i === 0) {
                $ownerId = 'a38f8ef4-400b-4229-a5ff-712ff5f72b27';
            }
            $command = new CreateOrganizationCommand($ownerId, 'Organization ' . $i, Uuid::generate());
            $memberIds[] = $ownerId;

            $this->commandBus->handle($command);

            $j = 0;
            $iterations = mt_rand(0, 5);
            while ($j < $iterations) {
                $memberId = UserFixturesCommand::USER_IDS[array_rand(UserFixturesCommand::USER_IDS)];
                if (in_array($memberId, $memberIds, true)) {
                    continue;
                }

                $this->commandBus->handle(
                    new AddOrganizationMemberToOrganizationCommand($memberId, $command->id(), $ownerId)
                );
                ++$j;
                $memberIds[] = $memberId;
            }
            $memberIds = [];
            ++$i;
            $progress->advance();
        }
        $progress->finish();
        $output->writeln('');
    }
}

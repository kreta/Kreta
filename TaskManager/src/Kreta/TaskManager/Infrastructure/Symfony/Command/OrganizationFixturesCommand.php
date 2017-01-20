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
use Kreta\SharedKernel\Domain\Model\CollectionElementAlreadyAddedException;
use Kreta\SharedKernel\Domain\Model\Identity\Uuid;
use Kreta\TaskManager\Application\Command\Organization\AddOrganizationMemberToOrganizationCommand;
use Kreta\TaskManager\Application\Command\Organization\CreateOrganizationCommand;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberIsAlreadyAnOwnerException;
use Symfony\Component\Console\Command\Command;
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        for ($i = 0; $i < 10; ++$i) {
            $userId = UserFixturesCommand::USER_IDS[array_rand(UserFixturesCommand::USER_IDS)];
            if ($i === 0) {
                $userId = 'a38f8ef4-400b-4229-a5ff-712ff5f72b27';
            }
            $command = new CreateOrganizationCommand($userId, 'Organization ' . $i, Uuid::generate());

            $this->commandBus->handle($command);

            try {
                $iterations = mt_rand(0, 2);
                for ($j = 0; $j < $iterations; ++$j) {
                    $this->commandBus->handle(
                        new AddOrganizationMemberToOrganizationCommand(
                            UserFixturesCommand::USER_IDS[array_rand(UserFixturesCommand::USER_IDS)],
                            $command->id(),
                            $userId
                        )
                    );
                }
            } catch (OrganizationMemberIsAlreadyAnOwnerException $exception) {
                $output->writeln($exception->getMessage());
            } catch (CollectionElementAlreadyAddedException $exception) {
                $output->writeln($exception->getMessage());
            }
        }

        $output->writeln('Organization population is successfully done');
    }
}

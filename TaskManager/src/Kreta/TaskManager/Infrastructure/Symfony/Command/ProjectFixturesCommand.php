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
use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Domain\Model\Identity\Uuid;
use Kreta\TaskManager\Application\Command\Project\CreateProjectCommand;
use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectFixturesCommand extends Command
{
    private $commandBus;
    private $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        parent::__construct('kreta:task-manager:fixtures:projects');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amount = 50;
        $output->writeln('');
        $output->writeln('Loading projects...');
        $progress = new ProgressBar($output, $amount);
        $progress->start();
        $i = 0;

        while ($i < $amount) {
            $userId = UserFixturesCommand::USER_IDS[array_rand(UserFixturesCommand::USER_IDS)];

            $this->queryBus->handle(
                new FilterOrganizationsQuery(
                    $userId,
                    0,
                    1
                ),
                $organizations
            );

            if (empty($organizations)) {
                continue;
            }

            $this->commandBus->handle(
                new CreateProjectCommand(
                    'Project ' . $i,
                    $organizations[0]['id'],
                    $organizations[0]['owners'][0]['id'],
                    Uuid::generate()
                )
            );
            ++$i;
            $progress->advance();
        }
        $progress->finish();
        $output->writeln('');
    }
}

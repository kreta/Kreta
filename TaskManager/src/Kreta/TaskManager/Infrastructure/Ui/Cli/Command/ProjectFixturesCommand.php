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

namespace Kreta\TaskManager\Infrastructure\Ui\Cli\Command;

use Kreta\SharedKernel\Application\CommandBus;
use Kreta\SharedKernel\Application\QueryBus;
use Kreta\SharedKernel\Domain\Model\Identity\Uuid;
use Kreta\TaskManager\Application\Command\Project\CreateProjectCommand;
use Kreta\TaskManager\Application\Query\Organization\FilterOrganizationsQuery;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectFixturesCommand extends ContainerAwareCommand
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
        for ($i = 0; $i < 50; ++$i) {
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
        }
        $output->writeln('Project population is successfully done');
    }
}

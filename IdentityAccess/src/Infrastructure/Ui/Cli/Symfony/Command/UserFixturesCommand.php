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

namespace Kreta\IdentityAccess\Infrastructure\Ui\Cli\Symfony\Command;

use BenGorUser\User\Application\Command\SignUp\SignUpUserCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserFixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fixtures:user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        for ($i = 0; $i < 20; ++$i) {
            $this->getContainer()->get('bengor_user.user.command_bus')->handle(
                new SignUpUserCommand(
                    'user' . $i . '@gmail.com',
                    '123456',
                    ['ROLE_USER']
                )
            );
        }

        $output->writeln('Population is successfully done');
    }
}

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

namespace Kreta\AppBundle\Command;

use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserId;
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
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');

        for ($i = 0; $i < 20; ++$i) {
            $user = new User(
                UserId::generate()
            );
            $manager->persist($user);
        }

        $manager->flush();

        $output->writeln('Population is successfully done');
    }
}

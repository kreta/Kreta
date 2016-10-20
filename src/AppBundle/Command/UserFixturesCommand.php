<?php

namespace Kreta\AppBundle\Command;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\Organization\Owner;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
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

        for ($i = 0; $i < 20; $i++) {
            $user = new User(
                UserId::generate()
            );
            $manager->persist($user);
        }

        $manager->flush();

        $output->writeln('Population is successfully done');
    }
}

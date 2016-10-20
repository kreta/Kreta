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

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationName;
use Kreta\TaskManager\Domain\Model\User\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrganizationFixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fixtures:organization');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $users = $this->getContainer()->get('doctrine')->getRepository(User::class)->findAll();

        $organizationId = OrganizationId::generate();
        $organization = new Organization(
            $organizationId,
            new OrganizationName('Organization name'),
            new Slug('Organization name'),
            $users[0]->id()
        );

        $i = 0;
        foreach ($users as $user) {
            if ($i > 0) {
                $organization->addOrganizationMember($user->id());
            }
            ++$i;
        }

        $manager->persist($organization);
        $manager->flush();
        $output->writeln('Population is successfully done');
    }
}

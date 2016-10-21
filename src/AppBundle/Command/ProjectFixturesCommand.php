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
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\User\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectFixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fixtures:project');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $organizations = $this->getContainer()->get('doctrine')->getRepository(Organization::class)->findAll();

        foreach($organizations as $organization) {
            $project = new Project(
                ProjectId::generate(),
                new ProjectName('Project name'),
                new Slug('project-name'),
                $organization->id()
            );

            $manager->persist($project);
        }

        $manager->flush();
        $output->writeln('Population is successfully done');
    }
}

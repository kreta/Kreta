<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Project\Factory\LabelFactory;
use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadIssuePriorityDataSpec.
 *
 * @package spec\Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadIssuePriorityDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\ORM\LoadIssuePriorityData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        LabelFactory $factory,
        IssuePriorityInterface $issuePriority,
        ObjectManager $manager
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findAll()->shouldBeCalled()->willReturn([$project]);
        $container->get('kreta_project.factory.issue_priority')->shouldBeCalled()->willReturn($factory);
        $factory->create($project, Argument::type('string'))->shouldBeCalled()->willReturn($issuePriority);

        $manager->persist($issuePriority)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_2_order()
    {
        $this->getOrder()->shouldReturn(2);
    }
}

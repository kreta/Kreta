<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Factory\ProjectRoleFactory;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Repository\ProjectRepository;
use Kreta\Component\Core\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadRoleDataSpec.
 *
 * @package spec\Kreta\Bundle\FixturesBundle
 */
class LoadRoleDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\ORM\LoadRoleData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        ProjectInterface $project2,
        ProjectInterface $project3,
        ProjectInterface $project4,
        UserRepository $userRepository,
        UserInterface $user,
        ProjectRoleFactory $factory,
        ProjectRoleInterface $projectRole,
        ObjectManager $manager
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findAll()->shouldBeCalled()->willReturn(array($project, $project2, $project3, $project4));

        $container->get('kreta_core.repository_user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn(array($user));

        $container->get('kreta_core.factory_projectRole')->shouldBeCalled()->willReturn($factory);
        $factory->create(Argument::type('Kreta\Component\Core\Model\Interfaces\ProjectInterface'), $user)
            ->shouldBeCalled()->willReturn($projectRole);

        $projectRole->setRole(Argument::type('string'))->shouldBeCalled()->willReturn($projectRole);

        $manager->persist($projectRole)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_2_order()
    {
        $this->getOrder()->shouldReturn(2);
    }
}

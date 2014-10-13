<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\CoreBundle\Factory\ProjectFactory;
use Kreta\CoreBundle\Model\Interfaces\ProjectInterface;
use Kreta\CoreBundle\Model\Interfaces\UserInterface;
use Kreta\CoreBundle\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadProjectDataSpec.
 *
 * @package spec\Kreta\FixturesBundle\DataFixtures\ORM
 */
class LoadProjectDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\FixturesBundle\DataFixtures\ORM\LoadProjectData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        UserRepository $userRepository,
        UserInterface $user,
        ProjectFactory $factory,
        ProjectInterface $project,
        ObjectManager $manager
    )
    {
        $container->get('kreta_core.repository_user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn(array($user));

        $container->get('kreta_core.factory_project')->shouldBeCalled()->willReturn($factory);
        $factory->create()->shouldBeCalled()->willReturn($project);

        $project->setName(Argument::type('string'))->shouldBeCalled()->willReturn($project);
        $project->addParticipant($user)->shouldBeCalled()->willReturn($project);
        $project->setShortName(Argument::type('string'))->shouldBeCalled()->willReturn($project);

        $manager->persist($project)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_1_order()
    {
        $this->getOrder()->shouldReturn(1);
    }
}

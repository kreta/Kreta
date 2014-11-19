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
use Kreta\Component\Core\Factory\ParticipantFactory;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Repository\ProjectRepository;
use Kreta\Component\Core\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadParticipantDataSpec.
 *
 * @package spec\Kreta\Bundle\FixturesBundle
 */
class LoadParticipantDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\ORM\LoadParticipantData');
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
        ParticipantFactory $factory,
        ParticipantInterface $participant,
        ObjectManager $manager
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findAll()->shouldBeCalled()->willReturn(array($project, $project2, $project3, $project4));

        $container->get('kreta_core.repository_user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn(array($user));

        $container->get('kreta_core.factory_participant')->willReturn($factory);
        $factory->create(Argument::type('Kreta\Component\Core\Model\Interfaces\ProjectInterface'), $user)
            ->willReturn($participant);

        $participant->setRole(Argument::type('string'))->willReturn($participant);

        $manager->persist($participant);

        $manager->flush();

        $this->load($manager);
    }

    function it_gets_2_order()
    {
        $this->getOrder()->shouldReturn(2);
    }
}

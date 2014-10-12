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

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Kreta\CoreBundle\Factory\IssueFactory;
use Kreta\CoreBundle\Model\Interfaces\IssueInterface;
use Kreta\CoreBundle\Model\Interfaces\LabelInterface;
use Kreta\CoreBundle\Model\Interfaces\UserInterface;
use Kreta\CoreBundle\Repository\LabelRepository;
use Kreta\CoreBundle\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadIssueDataSpec.
 *
 * @package spec\Kreta\FixturesBundle
 */
class LoadIssueDataSpec extends ObjectBehavior
{
    function let(ContainerInterface $container, ReferenceRepository $referenceRepository)
    {
        $this->setContainer($container);
        $this->setReferenceRepository($referenceRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\FixturesBundle\DataFixtures\ORM\LoadIssueData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        UserRepository $userRepository,
        LabelRepository $labelRepository,
        IssueFactory $factory,
        IssueInterface $issue,
        ReferenceRepository $referenceRepository,
        IssueInterface $issue,
        ObjectManager $manager,
        UserInterface $user,
        LabelInterface $label
    )
    {
        $container->get('kreta_core.repository_user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn(array($user));

        $container->get('kreta_core.repository_label')->shouldBeCalled()->willReturn($labelRepository);
        $labelRepository->findAll()->shouldBeCalled()->willReturn(array($label));

        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($factory);
        $factory->create()->shouldBeCalled()->willReturn($issue);

        $issue->addAssigner($user)->shouldBeCalled()->willReturn($issue);
        $issue->addLabel($label)->shouldBeCalled()->willReturn($issue);
        $issue->setPriority(Argument::type('int'))->shouldBeCalled()->willReturn($issue);
        $issue->setResolution(Argument::type('int'))->shouldBeCalled()->willReturn($issue);
        $issue->setReporter($user)->shouldBeCalled()->willReturn($issue);
        $issue->setStatus(Argument::type('int'))->shouldBeCalled()->willReturn($issue);
        $issue->setType(Argument::type('int'))->shouldBeCalled()->willReturn($issue);
        $issue->addWatcher(Argument::type('Kreta\CoreBundle\Model\Interfaces\UserInterface'))->shouldBeCalled()->willReturn($issue);

        $referenceRepository->addReference(Argument::type('string'), $issue)->shouldBeCalled();

        $manager->persist($issue)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_2_order()
    {
        $this->getOrder()->shouldReturn(2);
    }
}

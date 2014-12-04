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

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Factory\IssueFactory;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\LabelInterface;
use Kreta\Component\Core\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\ResolutionInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Repository\LabelRepository;
use Kreta\Component\Core\Repository\ParticipantRepository;
use Kreta\Component\Core\Repository\ProjectRepository;
use Kreta\Component\Core\Repository\ResolutionRepository;
use Kreta\Component\Core\Repository\StatusRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadIssueDataSpec.
 *
 * @package spec\Kreta\Bundle\FixturesBundle
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
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\ORM\LoadIssueData');
    }

    function it_extends_data_fixtures()
    {
        $this->shouldHaveType('Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures');
    }

    function it_loads(
        ContainerInterface $container,
        LabelRepository $labelRepository,
        ProjectRepository $projectRepository,
        StatusRepository $statusRepository,
        ResolutionRepository $resolutionRepository,
        ParticipantRepository $participantRepository,
        IssueFactory $factory,
        IssueInterface $issue,
        ReferenceRepository $referenceRepository,
        IssueInterface $issue,
        ObjectManager $manager,
        UserInterface $user,
        LabelInterface $label,
        ProjectInterface $project,
        StatusInterface $status,
        ResolutionInterface $resolution,
        ParticipantInterface $participant,
        UserInterface $user
    )
    {
        $container->get('kreta_core.repository_label')->shouldBeCalled()->willReturn($labelRepository);
        $labelRepository->findAll()->shouldBeCalled()->willReturn(array($label));

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findAll()->shouldBeCalled()->willReturn(array($project));

        $container->get('kreta_core.repository_resolution')->shouldBeCalled()->willReturn($resolutionRepository);
        $resolutionRepository->findAll()->shouldBeCalled()->willReturn(array($resolution));

        $container->get('kreta_core.repository_status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findByProject(Argument::type('Kreta\Component\Core\Model\Interfaces\ProjectInterface'))
            ->shouldBeCalled()->willReturn(array($status));

        $container->get('kreta_core.repository_participant')->shouldBeCalled()->willReturn($participantRepository);
        $participantRepository->findByProject($project)->shouldBeCalled()->willReturn(array($participant));
        $participant->getUser()->shouldBeCalled()->willReturn($user);

        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($factory);
        $factory->create(
            Argument::type('Kreta\Component\Core\Model\Interfaces\ProjectInterface'),
            Argument::type('Kreta\Component\Core\Model\Interfaces\UserInterface')
        )->shouldBeCalled()->willReturn($issue);

        $issue->setAssignee($user)->shouldBeCalled()->willReturn($issue);
        $issue->setDescription(
            'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
                massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
                quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec
                pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a,
                venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.
                Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu,
                consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi
                vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus
                eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam
                nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.
                Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros
                faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed
                consequat, leo eget bibendum sodales, augue velit cursus nunc'
        )->shouldBeCalled()->willReturn($issue);
        $issue->addLabel($label)->shouldBeCalled()->willReturn($issue);
        $project->getShortName()->shouldBeCalled()->willReturn('PR01');
        $issue->setNumericId(Argument::type('int'))->shouldBeCalled()->willReturn($issue);
        $issue->setPriority(Argument::type('int'))->shouldBeCalled()->willReturn($issue);
        $issue->setResolution(Argument::type('Kreta\Component\Core\Model\Interfaces\ResolutionInterface'))
            ->shouldBeCalled()->willReturn($issue);
        $issue->setReporter($user)->shouldBeCalled()->willReturn($issue);
        $issue->setStatus(Argument::type('Kreta\Component\Core\Model\Interfaces\StatusInterface'))
            ->shouldBeCalled()->willReturn($issue);
        $issue->setTitle(Argument::type('string'))->shouldBeCalled()->willReturn($issue);
        $issue->setType(Argument::type('int'))->shouldBeCalled()->willReturn($issue);
        $issue->addWatcher(Argument::type('Kreta\Component\Core\Model\Interfaces\UserInterface'))
            ->shouldBeCalled()->willReturn($issue);

        $referenceRepository->addReference(Argument::type('string'), $issue)->shouldBeCalled();

        $manager->persist($issue)->shouldBeCalled();

        $manager->flush()->shouldBeCalled();

        $this->load($manager);
    }

    function it_gets_3_order()
    {
        $this->getOrder()->shouldReturn(3);
    }
}

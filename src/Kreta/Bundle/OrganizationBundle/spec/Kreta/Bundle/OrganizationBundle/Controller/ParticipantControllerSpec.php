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

namespace spec\Kreta\Bundle\OrganizationBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Organization\Repository\ParticipantRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Spec file of ParticipantController class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\OrganizationBundle\Controller\ParticipantController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_participants(
        ContainerInterface $container,
        Request $request,
        ParticipantRepository $participantRepository,
        ParamFetcher $paramFetcher,
        OrganizationInterface $organization,
        ParticipantInterface $participant
    ) {
        $container->get('kreta_organization.repository.participant')
            ->shouldBeCalled()->willReturn($participantRepository);
        $request->get('organization')->shouldBeCalled()->willReturn($organization);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(2);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(0);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $participantRepository->findByOrganization($organization, 2, 0, 'kreta@kreta.com')
            ->shouldBeCalled()->willReturn([$participant]);

        $this->getParticipantsAction($request, 'organization-id', $paramFetcher)->shouldReturn([$participant]);
    }

    function it_posts_participant(
        ContainerInterface $container,
        OrganizationInterface $organization,
        UserRepository $userRepository,
        UserInterface $user,
        Request $request,
        Handler $handler,
        ParticipantInterface $participant
    ) {
        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn([$user]);

        $container->get('kreta_organization.form_handler.participant')->shouldBeCalled()->willReturn($handler);
        $request->get('organization')->shouldBeCalled()->willReturn($organization);
        $handler->processForm($request, null, ['organization' => $organization, 'users' => [$user]])
            ->shouldBeCalled()->willReturn($participant);

        $this->postParticipantsAction($request, 'organization-id')->shouldReturn($participant);
    }

    function it_deletes_participant(
        ContainerInterface $container,
        ParticipantRepository $participantRepository,
        ParticipantInterface $participant
    ) {
        $container->get('kreta_organization.repository.participant')
            ->shouldBeCalled()->willReturn($participantRepository);
        $participantRepository->findOneBy(['organization' => 'organization-id', 'user' => 'user-id'], false)
            ->shouldBeCalled()->willReturn($participant);
        $participantRepository->remove($participant)->shouldBeCalled();

        $this->deleteParticipantsAction('organization-id', 'user-id');
    }
}

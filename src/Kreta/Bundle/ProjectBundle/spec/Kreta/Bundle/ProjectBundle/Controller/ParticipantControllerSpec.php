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

namespace spec\Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ParticipantRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ParticipantControllerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ParticipantControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Controller\ParticipantController');
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
        ProjectInterface $project,
        ParticipantInterface $participant
    )
    {
        $container->get('kreta_project.repository.participant')->shouldBeCalled()->willReturn($participantRepository);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(2);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(0);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $participantRepository->findByProject($project, 2, 0, 'kreta@kreta.com')
            ->shouldBeCalled()->willReturn([$participant]);

        $this->getParticipantsAction($request, 'project-id', $paramFetcher)->shouldReturn([$participant]);
    }

    function it_posts_participant(
        ContainerInterface $container,
        Request $request,
        ProjectInterface $project,
        UserRepository $userRepository,
        UserInterface $user,
        Request $request,
        Handler $handler,
        ParticipantInterface $participant
    )
    {
        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn([$user]);

        $container->get('kreta_project.form_handler.participant')->shouldBeCalled()->willReturn($handler);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $handler->processForm($request, null, ['project' => $project, 'users' => [$user]])
            ->shouldBeCalled()->willReturn($participant);

        $this->postParticipantsAction($request, 'project-id')->shouldReturn($participant);
    }

    function it_deletes_participant(
        ContainerInterface $container,
        ParticipantRepository $participantRepository,
        ParticipantInterface $participant
    )
    {
        $container->get('kreta_project.repository.participant')->shouldBeCalled()->willReturn($participantRepository);
        $participantRepository->findOneBy(['project' => 'project-id', 'user' => 'user-id'], false)
            ->shouldBeCalled()->willReturn($participant);
        $participantRepository->remove($participant)->shouldBeCalled();

        $this->deleteParticipantsAction('project-id', 'user-id');
    }
}

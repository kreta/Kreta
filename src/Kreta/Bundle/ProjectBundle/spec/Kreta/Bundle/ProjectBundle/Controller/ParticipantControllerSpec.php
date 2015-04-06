<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\spec\Kreta\Bundle\CoreBundle\Controller\BaseRestController;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ParticipantRepository;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\User\Repository\UserRepository;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ParticipantControllerSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Controller
 */
class ParticipantControllerSpec extends BaseRestController
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

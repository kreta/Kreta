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

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_gets_participants(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ParticipantRepository $participantRepository,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $context,
        ProjectInterface $project,
        ParticipantInterface $participant
    )
    {
        $project = $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $context);
        $container->get('kreta_project.repository.participant')->shouldBeCalled()->willReturn($participantRepository);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(2);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(0);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('kreta@kreta.com');
        $participantRepository->findByProject($project, 2, 0, 'kreta@kreta.com')
            ->shouldBeCalled()->willReturn([$participant]);

        $this->getParticipantsAction('project-id', $paramFetcher)->shouldReturn([$participant]);
    }

    function it_does_not_get_participants_because_the_user_has_not_the_required_grant(
        ParticipantRepository $participantRepository,
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_project.repository.participant')->shouldBeCalled()->willReturn($participantRepository);
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getParticipantsAction', ['project-id', $paramFetcher]);
    }

    function it_does_not_post_participant_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'add_participant', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('postParticipantsAction', ['project-id']);
    }

    function it_posts_participant(
        ContainerInterface $container,
        Request $request,
        ProjectRepository $projectRepository,
        SecurityContextInterface $securityContext,
        ProjectInterface $project,
        UserRepository $userRepository,
        UserInterface $user,
        Request $request,
        Handler $handler,
        ParticipantInterface $participant
    )
    {
        $project = $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'add_participant'
        );
        $container->get('kreta_user.repository.user')->shouldBeCalled()->willReturn($userRepository);
        $userRepository->findAll()->shouldBeCalled()->willReturn([$user]);

        $container->get('kreta_project.form_handler.participant')
            ->shouldBeCalled()->willReturn($handler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, null, ['project' => $project, 'users' => [$user]])
            ->shouldBeCalled()->willReturn($participant);

        $this->postParticipantsAction('project-id')->shouldReturn($participant);
    }

    function it_does_not_delete_participant_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'delete_participant', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('deleteParticipantsAction', ['project-id', 'user-id']);
    }

    function it_deletes_participant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        ParticipantRepository $participantRepository,
        ParticipantInterface $participant
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'delete_participant'
        );
        $container->get('kreta_project.repository.participant')->shouldBeCalled()->willReturn($participantRepository);
        $participantRepository->findOneBy(['project' => 'project-id', 'user' => 'user-id'], false)
            ->shouldBeCalled()->willReturn($participant);
        $participantRepository->remove($participant)->shouldBeCalled();

        $this->deleteParticipantsAction('project-id', 'user-id');
    }
}

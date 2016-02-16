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

namespace spec\Kreta\Bundle\WebBundle\Controller\Api;

use Kreta\Bundle\ProjectBundle\Security\Authorization\Voter\ProjectVoter;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Spec file of ProjectController class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ProjectControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\Api\ProjectController');
    }

    function it_extends_symfony_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_project(
        ContainerInterface $container,
        ProjectRepository $repository,
        ProjectInterface $project,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(
            ['o.slug' => 'organization-slug', 'slug' => 'project-slug'], false
        )->shouldBeCalled()->willReturn($project);

        $container->get('security.authorization_checker')->shouldBeCalled()->willReturn($authorizationChecker);
        $authorizationChecker->isGranted(ProjectVoter::VIEW, $project)
            ->shouldBeCalled()->willReturn(true);

        $this->getOrganizationProjectAction('organization-slug', 'project-slug')->shouldReturn($project);
    }

    function it_does_not_get_project_because_the_user_logged_is_not_project_participant(
        ContainerInterface $container,
        ProjectRepository $repository,
        ProjectInterface $project,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(
            ['o.slug' => 'organization-slug', 'slug' => 'project-slug'], false
        )->shouldBeCalled()->willReturn($project);

        $container->get('security.authorization_checker')->shouldBeCalled()->willReturn($authorizationChecker);
        $authorizationChecker->isGranted(ProjectVoter::VIEW, $project)
            ->shouldBeCalled()->willReturn(false);

        $this->shouldThrow('Symfony\Component\Security\Core\Exception\AccessDeniedException')
            ->duringGetOrganizationProjectAction('organization-slug', 'project-slug');
    }

    function it_gets_my_projects(
        ContainerInterface $container,
        UserInterface $user,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        TokenStorageInterface $context,
        TokenInterface $token
    ) {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $projectRepository->findBy([
            'creator' => $user, 'isNull' => ['organization' => null],
        ])->shouldBeCalled()->willReturn([$project]);

        $this->getMyProjectsAction()->shouldReturn([$project]);
    }

    function it_gets_my_project_of_given_slug(
        ContainerInterface $container,
        UserInterface $user,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        TokenStorageInterface $context,
        TokenInterface $token
    ) {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $projectRepository->findOneBy([
            'creator' => $user, 'slug' => 'project-slug', 'isNull' => ['organization' => null],
        ], false)->shouldBeCalled()->willReturn($project);

        $this->getMyProjectAction('project-slug')->shouldReturn($project);
    }
}

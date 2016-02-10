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
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
}

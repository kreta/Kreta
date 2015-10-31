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
use Kreta\Component\Project\Form\Handler\ProjectHandler;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class ProjectControllerSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Controller
 */
class ProjectControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Controller\ProjectController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_projects(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ParamFetcher $paramFetcher,
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user,
        ProjectInterface $project
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('name');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $projectRepository->findByParticipant($user, ['name' => 'ASC'], 10, 1)->shouldBeCalled()->willReturn([$project]);

        $this->getProjectsAction($paramFetcher)->shouldReturn([$project]);
    }

    function it_gets_project(Request $request, ProjectInterface $project)
    {
        $request->get('project')->shouldBeCalled()->willReturn($project);

        $this->getProjectAction($request, 'project-id')->shouldReturn($project);
    }

    function it_posts_project(
        ContainerInterface $container,
        Request $request,
        ProjectHandler $projectHandler,
        ProjectInterface $project,
        Request $request
    )
    {
        $container->get('kreta_project.form_handler.project')->shouldBeCalled()->willReturn($projectHandler);
        $projectHandler->processForm($request)->shouldBeCalled()->willReturn($project);

        $this->postProjectsAction($request)->shouldReturn($project);
    }

    function it_puts_project(
        ContainerInterface $container,
        ProjectInterface $project,
        Request $request,
        ProjectHandler $projectHandler
    )
    {
        $container->get('kreta_project.form_handler.project')->shouldBeCalled()->willReturn($projectHandler);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $projectHandler->processForm($request, $project, ['method' => 'PUT'])->shouldBeCalled()->willReturn($project);

        $this->putProjectsAction($request, 'project-id')->shouldReturn($project);
    }
}

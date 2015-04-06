<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\IssueBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueControllerSpec.
 *
 * @package spec\Kreta\Bundle\IssueBundle\Controller
 */
class IssueControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\Controller\IssueController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_issues(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher,
        IssueInterface $issue,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);

        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('createdAt');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('title-filter');
        $paramFetcher->get('project')->shouldBeCalled()->willReturn('KRT');
        $paramFetcher->get('assignee')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('reporter')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('watcher')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('priority')->shouldBeCalled()->willReturn('Low');
        $paramFetcher->get('status')->shouldBeCalled()->willReturn('done');
        $paramFetcher->get('type')->shouldBeCalled()->willReturn('Bug');

        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $issueRepository->findByParticipant(
            $user,
            [
                'title'       => 'title-filter',
                'p.shortName' => 'KRT',
                'a.email'     => 'user@kreta.com',
                'rep.email'   => 'user@kreta.com',
                'w.email'     => 'user@kreta.com',
                'pr.name'     => 'Low',
                's.name'      => 'done',
                't.name'      => 'Bug'
            ],
            ['createdAt' => 'ASC'],
            10,
            1
        )->shouldBeCalled()->willReturn([$issue]);

        $this->getIssuesAction($paramFetcher)->shouldReturn([$issue]);
    }

    function it_gets_issue(Request $request, IssueInterface $issue)
    {
        $request->get('issue')->shouldBeCalled()->willReturn($issue);

        $this->getIssueAction($request, 'issue-id')->shouldReturn($issue);
    }

    function it_posts_issue(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        Handler $handler,
        Request $request,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $projectRepository->findByParticipant($user)->shouldBeCalled()->willReturn([$project]);

        $container->get('kreta_issue.form_handler.issue')->shouldBeCalled()->willReturn($handler);
        $handler->processForm($request, null, ['projects' => [$project]])->shouldBeCalled()->willReturn($issue);

        $this->postIssuesAction($request)->shouldReturn($issue);
    }

    function it_puts_issue(
        ContainerInterface $container,
        Handler $handler,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        TokenInterface $token,
        UserInterface $user,
        Request $request
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $projectRepository->findByParticipant($user)->shouldBeCalled()->willReturn([$project]);

        $container->get('kreta_issue.form_handler.issue')->shouldBeCalled()->willReturn($handler);
        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $handler->processForm(
            $request, $issue, ['method' => 'PUT', 'projects' => [$project]]
        )->shouldBeCalled()->willReturn($issue);

        $this->putIssuesAction($request, 'issue-id')->shouldReturn($issue);
    }
}

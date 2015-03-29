<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\IssueBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\CoreBundle\spec\Kreta\Bundle\CoreBundle\Controller\BaseRestController;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueControllerSpec.
 *
 * @package spec\Kreta\Bundle\IssueBundle\Controller
 */
class IssueControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\Controller\IssueController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
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
        $paramFetcher->get('priority')->shouldBeCalled()->willReturn(0);
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
                'priority'    => 0,
                's.name'      => 'done',
                't.name'      => 'Bug'
            ],
            ['createdAt' => 'ASC'],
            10,
            1
        )->shouldBeCalled()->willReturn([$issue]);

        $this->getIssuesAction($paramFetcher)->shouldReturn([$issue]);
    }

    function it_gets_issue(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $issue = $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext);

        $this->getIssueAction('issue-id')->shouldReturn($issue);
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
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, null, ['projects' => [$project]])->shouldBeCalled()->willReturn($issue);

        $this->postIssuesAction()->shouldReturn($issue);
    }

    function it_does_not_put_issue_because_the_user_has_not_the_required_grant_for_issue(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext, 'edit', false);

        $this->shouldThrow(new AccessDeniedException())->during('putIssuesAction', ['issue-id']);
    }

    function it_puts_issue(
        ContainerInterface $container,
        Handler $handler,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        TokenInterface $token,
        UserInterface $user,
        Request $request
    )
    {
        $issue = $this->getIssueIfAllowedSpec($container, $issueRepository, $issue, $securityContext, 'edit');
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $projectRepository->findByParticipant($user)->shouldBeCalled()->willReturn([$project]);

        $container->get('kreta_issue.form_handler.issue')->shouldBeCalled()->willReturn($handler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, $issue, ['method' => 'PUT', 'projects' => [$project]])
            ->shouldBeCalled()->willReturn($issue);

        $this->putIssuesAction('issue-id')->shouldReturn($issue);
    }
}

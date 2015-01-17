<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Bundle\ApiBundle\Form\Handler\IssueHandler;
use Kreta\Bundle\ApiBundle\spec\Kreta\Bundle\ApiBundle\Controller\BaseRestController;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Project\Repository\ProjectRepository;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class IssueControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\IssueController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\RestController');
    }

    function it_does_not_get_issues_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher
    )
    {
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getIssuesAction', ['project-id', $paramFetcher]);
    }

    function it_gets_issues(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher,
        IssueInterface $issue
    )
    {
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext);

        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('createdAt');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('title-filter');
        $paramFetcher->get('assignee')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('reporter')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('watcher')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('priority')->shouldBeCalled()->willReturn(0);
        $paramFetcher->get('status')->shouldBeCalled()->willReturn('done');
        $paramFetcher->get('type')->shouldBeCalled()->willReturn(1);

        $issueRepository->findBy(
            [
                'project' => $project,
                'like' => [
                    'title'     => 'title-filter',
                    'a.email'   => 'user@kreta.com',
                    'rep.email' => 'user@kreta.com',
                    'w.email'   => 'user@kreta.com',
                    'priority'  => 0,
                    's.name'    => 'done',
                    'type'      => 1
                ]
            ],
            ['createdAt' => 'ASC'],
            10,
            1
        )->shouldBeCalled()->willReturn([$issue]);

        $this->getIssuesAction('project-id', $paramFetcher)->shouldReturn([$issue]);
    }

    function it_does_not_get_issue_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowed(
            $container, $projectRepository, $project, $issueRepository, $issue, $securityContext, 'view', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('getIssueAction', ['project-id', 'issue-id']);
    }

    function it_gets_issue(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $issue = $this->getIssueIfAllowed(
            $container, $projectRepository, $project, $issueRepository, $issue, $securityContext
        );

        $this->getIssueAction('project-id', 'issue-id')->shouldReturn($issue);
    }

    function it_does_not_post_issues_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'create_issue', false);

        $this->shouldThrow(new AccessDeniedException())->during('postIssuesAction', ['project-id']);
    }

    function it_posts_issue(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        IssueHandler $issueHandler,
        Request $request,
        IssueInterface $issue
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'create_issue');

        $container->get('kreta_api.form_handler.issue')->shouldBeCalled()->willReturn($issueHandler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $issueHandler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($issue);

        $this->postIssuesAction('project-id')->shouldReturn($issue);
    }

    function it_does_not_put_issue_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('putIssuesAction', ['project-id', 'issue-id']);
    }

    function it_does_not_put_issue_because_the_user_has_not_the_required_grant_for_issue(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowed(
            $container, $projectRepository, $project, $issueRepository, $issue, $securityContext, 'edit', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('putIssuesAction', ['project-id', 'issue-id']);
    }

    function it_puts_issue(
        ContainerInterface $container,
        IssueHandler $issueHandler,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        Request $request
    )
    {
        $issue = $this->getIssueIfAllowed(
            $container, $projectRepository, $project, $issueRepository, $issue, $securityContext, 'edit'
        );

        $container->get('kreta_api.form_handler.issue')->shouldBeCalled()->willReturn($issueHandler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $issueHandler->processForm($request, $issue, ['method' => 'PUT', 'project' => $project])
            ->shouldBeCalled()->willReturn($issue);

        $this->putIssuesAction('project-id', 'issue-id')->shouldReturn($issue);
    }

    private function getIssueIfAllowed(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        $issueGrant = 'view',
        $issueResult = true
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext);

        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->find('issue-id', false)->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($issueGrant, $issue)->shouldBeCalled()->willReturn($issueResult);

        return $issue;
    }
}

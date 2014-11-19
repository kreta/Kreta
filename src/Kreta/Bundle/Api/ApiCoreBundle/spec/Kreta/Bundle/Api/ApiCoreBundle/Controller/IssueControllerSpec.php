<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\Api\ApiCoreBundle\Controller;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\ViewHandler;
use Kreta\Bundle\Api\ApiCoreBundle\Form\Type\IssueType;
use Kreta\Component\Core\Factory\IssueFactory;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Repository\IssueRepository;
use Kreta\Component\Core\Repository\ProjectRepository;
use Prophecy\Argument;
use spec\Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestControllerSpec;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueControllerSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Controller
 */
class IssueControllerSpec extends AbstractRestControllerSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\IssueController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_issues_because_the_project_does_not_exist(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        ProjectRepository $projectRepository,
        ParamFetcher $paramFetcher
    )
    {
        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);

        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getIssuesAction', ['project-id', $paramFetcher]);
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
        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);

        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getIssuesAction', ['project-id', $paramFetcher]);
    }

    function it_gets_issues(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        ParamFetcher $paramFetcher,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);

        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext);

        $paramFetcher->get('order')->shouldBeCalled()->willReturn('created-at');
        $paramFetcher->get('count')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('page')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('title-filter');
        $paramFetcher->get('assignee')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('reporter')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('watcher')->shouldBeCalled()->willReturn('user@kreta.com');
        $paramFetcher->get('priority')->shouldBeCalled()->willReturn(0);
        $paramFetcher->get('status')->shouldBeCalled()->willReturn('done');
        $paramFetcher->get('type')->shouldBeCalled()->willReturn(1);

        $issueRepository->findByProject(
            $project,
            ['created-at' => 'ASC'],
            10,
            1,
            [
                'title'     => 'title-filter',
                'a.email'   => 'user@kreta.com',
                'rep.email' => 'user@kreta.com',
                'w.email'   => 'user@kreta.com',
                'priority'  => 0,
                's.name'    => 'done',
                'type'      => 1
            ]
        )->shouldBeCalled()->willReturn([]);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getIssuesAction('project-id', $paramFetcher)->shouldReturn($response);
    }

    function it_does_not_get_issue_because_the_issue_does_not_exist(
        ContainerInterface $container,
        IssueRepository $issueRepository
    )
    {
        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->find('issue-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with issue-id id'))
            ->during('getIssueAction', ['project-id', 'issue-id']);
    }

    function it_does_not_get_issue_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowed($container, $issueRepository, $issue, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getIssueAction', ['project-id', 'issue-id']);
    }

    function it_gets_issue(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getIssueIfAllowed($container, $issueRepository, $issue, $securityContext);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getIssueAction('project-id', 'issue-id')->shouldReturn($response);
    }

    function it_does_not_post_issues_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('postIssuesAction', ['project-id']);
    }

    function it_does_not_post_issues_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'create_issue', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('postIssuesAction', ['project-id']);
    }

    function it_does_not_post_issues_because_the_user_is_not_logged(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        IssueFactory $issueFactory
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'create_issue');
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);

        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($issueFactory);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('postIssuesAction', ['project-id']);
    }

    function it_does_not_post_issues_because_there_are_some_form_errors(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        IssueFactory $issueFactory,
        IssueInterface $issue,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'create_issue');
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($issueFactory);
        $issueFactory->create($project, $user)->shouldBeCalled()->willReturn($issue);
        $project->getParticipants()->shouldBeCalled()->willReturn([]);

        $this->getFormErrors(
            $container,
            $request,
            $formFactory,
            $form,
            $error,
            $formChild,
            $formGrandChild,
            $viewHandler,
            $response,
            new IssueType([]),
            $issue
        );

        $this->postIssuesAction('project-id')->shouldReturn($response);
    }

    function it_posts_issue(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        TokenInterface $token,
        UserInterface $user,
        IssueFactory $issueFactory,
        IssueInterface $issue,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'create_issue');
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($issueFactory);
        $issueFactory->create($project, $user)->shouldBeCalled()->willReturn($issue);
        $project->getParticipants()->shouldBeCalled()->willReturn([]);

        $this->processForm(
            $container,
            $request,
            $formFactory,
            $form,
            $registry,
            $manager,
            $viewHandler,
            $response,
            new IssueType([]),
            $issue
        );

        $this->postIssuesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_put_issue_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $this->getProjectIfExist($container, $projectRepository);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('putIssuesAction', ['project-id', 'issue-id']);
    }

    function it_does_not_put_issue_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('putIssuesAction', ['project-id', 'issue-id']);
    }

    function it_does_not_put_issue_because_the_issue_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        IssueRepository $issueRepository
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext);
        $project->getParticipants()->shouldBeCalled()->willReturn([]);

        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->find('issue-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with issue-id id'))
            ->during('putIssuesAction', ['project-id', 'issue-id']);
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
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext);
        $project->getParticipants()->shouldBeCalled()->willReturn([]);

        $this->getIssueIfAllowed($container, $issueRepository, $issue, $securityContext, 'edit', false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('putIssuesAction', ['project-id', 'issue-id']);
    }


    function it_does_not_put_issue_because_there_are_some_form_errors(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        FormError $error,
        FormInterface $formChild,
        FormInterface $formGrandChild,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext);
        $project->getParticipants()->shouldBeCalled()->willReturn([]);

        $this->getIssueIfAllowed($container, $issueRepository, $issue, $securityContext, 'edit');

        $this->getFormErrors(
            $container,
            $request,
            $formFactory,
            $form,
            $error,
            $formChild,
            $formGrandChild,
            $viewHandler,
            $response,
            new IssueType([]),
            $issue,
            'PUT'
        );

        $this->putIssuesAction('project-id', 'issue-id')->shouldReturn($response);
    }

    function it_puts_issue(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        Request $request,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        AbstractManagerRegistry $registry,
        ObjectManager $manager,
        ViewHandler $viewHandler,
        Response $response
    )
    {
        $this->getProjectIfAllowed($container, $projectRepository, $project, $securityContext);
        $project->getParticipants()->shouldBeCalled()->willReturn([]);

        $this->getIssueIfAllowed($container, $issueRepository, $issue, $securityContext, 'edit');

        $this->processForm(
            $container,
            $request,
            $formFactory,
            $form,
            $registry,
            $manager,
            $viewHandler,
            $response,
            new IssueType([]),
            $issue,
            'PUT'
        );

        $this->putIssuesAction('project-id', 'issue-id')->shouldReturn($response);
    }

    private function getIssueIfAllowed(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->find('issue-id')->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $issue)->shouldBeCalled()->willReturn($result);
    }
}

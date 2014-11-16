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
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
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
class IssueControllerSpec extends ObjectBehavior
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

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('getIssuesAction', array('project-id', $paramFetcher));
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

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getIssuesAction', array('project-id', $paramFetcher));
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

        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);

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
            array('created-at' => 'ASC'),
            10,
            1,
            array(
                'title'     => 'title-filter',
                'a.email'   => 'user@kreta.com',
                'rep.email' => 'user@kreta.com',
                'w.email'   => 'user@kreta.com',
                'priority'  => 0,
                's.name'    => 'done',
                'type'      => 1
            )
        )->shouldBeCalled()->willReturn(array());

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
        $issueRepository->findOneById('issue-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with issue-id id'))
            ->during('getIssueAction', array('project-id', 'issue-id'));
    }

    function it_does_not_get_issue_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findOneById('issue-id')->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $issue)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('getIssueAction', array('project-id', 'issue-id'));
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
        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findOneById('issue-id')->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $issue)->shouldBeCalled()->willReturn(true);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->getIssueAction('project-id', 'issue-id')->shouldReturn($response);
    }

    function it_does_not_post_issues_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('postIssuesAction', array('project-id'));
    }

    function it_does_not_post_issues_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('create_issue', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('postIssuesAction', array('project-id'));
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
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);

        $securityContext->isGranted('create_issue', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($issueFactory);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('postIssuesAction', array('project-id'));
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
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $securityContext->isGranted('create_issue', $project)->shouldBeCalled()->willReturn(true);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($issueFactory);
        $issueFactory->create($project, $user)
            ->shouldBeCalled()->willReturn($issue);
        $project->getParticipants()->shouldBeCalled()->willReturn(array());

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $formFactory->create(new IssueType(array()), $issue, array('csrf_protection' => false, 'method' => 'POST'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $form->all()->shouldBeCalled()->willReturn(array($formChild));
        $formChild->isValid()->shouldBeCalled()->willReturn(false);
        $formChild->getName()->shouldBeCalled()->willReturn('form child name');
        $formChild->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $formChild->all()->shouldBeCalled()->willReturn(array($formGrandChild));
        $formGrandChild->isValid()->shouldBeCalled()->willReturn(true);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

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
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $securityContext->isGranted('create_issue', $project)->shouldBeCalled()->willReturn(true);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $container->get('kreta_core.factory_issue')->shouldBeCalled()->willReturn($issueFactory);
        $issueFactory->create($project, $user)
            ->shouldBeCalled()->willReturn($issue);
        $project->getParticipants()->shouldBeCalled()->willReturn(array());

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('POST');
        $formFactory->create(new IssueType(array()), $issue, array('csrf_protection' => false, 'method' => 'POST'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($issue)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->postIssuesAction('project-id')->shouldReturn($response);
    }

    function it_does_not_put_issue_because_the_project_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with project-id id'))
            ->during('putIssuesAction', array('project-id', 'issue-id'));
    }

    function it_does_not_put_issue_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('putIssuesAction', array('project-id', 'issue-id'));
    }

    function it_does_not_put_issue_because_the_issue_does_not_exist(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        IssueRepository $issueRepository
    )
    {
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);
        $project->getParticipants()->shouldBeCalled()->willReturn(array());

        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findOneById('issue-id')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new NotFoundHttpException('Does not exist any entity with issue-id id'))
            ->during('putIssuesAction', array('project-id', 'issue-id'));
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
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);
        $project->getParticipants()->shouldBeCalled()->willReturn(array());

        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findOneById('issue-id')->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $issue)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new AccessDeniedException('Not allowed to access this resource'))
            ->during('putIssuesAction', array('project-id', 'issue-id'));
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
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);
        $project->getParticipants()->shouldBeCalled()->willReturn(array());

        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findOneById('issue-id')->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $issue)->shouldBeCalled()->willReturn(true);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('PUT');
        $formFactory->create(new IssueType(array()), $issue, array('csrf_protection' => false, 'method' => 'PUT'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $form->all()->shouldBeCalled()->willReturn(array($formChild));
        $formChild->isValid()->shouldBeCalled()->willReturn(false);
        $formChild->getName()->shouldBeCalled()->willReturn('form child name');
        $formChild->getErrors()->shouldBeCalled()->willReturn(array($error));
        $error->getMessage()->shouldBeCalled()->willReturn('error message');
        $formChild->all()->shouldBeCalled()->willReturn(array($formGrandChild));
        $formGrandChild->isValid()->shouldBeCalled()->willReturn(true);

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

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
        $container->get('kreta_core.repository_project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->findOneById('project-id')->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $project)->shouldBeCalled()->willReturn(true);
        $project->getParticipants()->shouldBeCalled()->willReturn(array());

        $container->get('kreta_core.repository_issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->findOneById('issue-id')->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $issue)->shouldBeCalled()->willReturn(true);

        $container->get('request')->shouldBeCalled()->willReturn($request);
        $container->get('form.factory')->shouldBeCalled()->willReturn($formFactory);
        $request->getMethod()->shouldBeCalled()->willReturn('PUT');
        $formFactory->create(new IssueType(array()), $issue, array('csrf_protection' => false, 'method' => 'PUT'))
            ->shouldBeCalled()->willReturn($form);
        $form->handleRequest($request)->shouldBeCalled()->willReturn($form);
        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($registry);
        $registry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->persist($issue)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $container->get('fos_rest.view_handler')->shouldBeCalled()->willReturn($viewHandler);
        $viewHandler->handle(Argument::type('FOS\RestBundle\View\View'))->shouldBeCalled()->willReturn($response);

        $this->putIssuesAction('project-id', 'issue-id')->shouldReturn($response);
    }
}

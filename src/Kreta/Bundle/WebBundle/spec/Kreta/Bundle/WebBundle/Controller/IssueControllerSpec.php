<?php

namespace spec\Kreta\Bundle\WebBundle\Controller;

use Kreta\Bundle\WebBundle\FormHandler\IssueFormHandler;
use Kreta\Component\Core\Factory\IssueFactory;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Repository\IssueRepository;
use Kreta\Component\Core\Repository\ProjectRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class IssueControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\Controller\IssueController');
    }

    function it_shows_issue(ContainerInterface $container, SecurityContextInterface $securityContext,
                            IssueRepository $repository, IssueInterface $issue)
    {
        $projectShortName = 'TEST';
        $issueNumber = 42;

        $container->get('kreta_core.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->findOneByShortCode($projectShortName, $issueNumber)->shouldBeCalled()->willReturn($issue);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $issue)->shouldBeCalled()->willReturn(true);

        $this->viewAction($projectShortName, $issueNumber)->shouldReturn(['issue' => $issue]);
    }

    function it_shows_error_when_issue_not_found(ContainerInterface $container, IssueRepository $repository)
    {
        $projectShortName = 'TEST';
        $issueNumber = 42;

        $container->get('kreta_core.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->findOneByShortCode($projectShortName, $issueNumber)->shouldBeCalled()->willReturn(null);

        $this->shouldThrow('\Symfony\Component\HttpKernel\Exception\NotFoundHttpException')
            ->duringViewAction($projectShortName, $issueNumber);

    }

    function it_denies_viewing_access(ContainerInterface $container, SecurityContextInterface $securityContext,
                                      IssueRepository $repository, IssueInterface $issue)
    {
        $projectShortName = 'TEST';
        $issueNumber = 42;

        $container->get('kreta_core.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->findOneByShortCode($projectShortName, $issueNumber)->shouldBeCalled()->willReturn($issue);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('view', $issue)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow('\Symfony\Component\Security\Core\Exception\AccessDeniedException')
            ->duringViewAction($projectShortName, $issueNumber);
    }

    function it_shows_new_issue_form(ContainerInterface $container, SecurityContextInterface $securityContext,
                                     ProjectRepository $repository, ProjectInterface $project, IssueFactory $factory,
                                     UserInterface $user, IssueFormHandler $formHandler, IssueInterface $issue,
                                     Request $request, FormInterface $form, FormView $formView, TokenInterface $token)
    {
        $projectShortName = 'TEST';

        $container->get('kreta_core.repository.project')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(['shortName' => $projectShortName])->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('create_issue', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.factory.issue')->shouldBeCalled()->willReturn($factory);
        $this->getUserStub($container, $securityContext, $token, $user);
        $factory->create($project, $user)->shouldBeCalled()->willReturn($issue);

        $project->getParticipants()->shouldBeCalled()->willReturn([$user]);
        $container->get('kreta_web.form_handler.issue')->shouldBeCalled()->willReturn($formHandler);
        $formHandler->handleForm($request, $issue, ['participants' => [$user]])->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->createView()->shouldBeCalled()->willReturn($formView);

        $this->newAction($projectShortName, $request)->shouldReturn(['form' => $formView, 'project' => $project]);
    }

    function it_creates_new_issue(ContainerInterface $container, SecurityContextInterface $securityContext,
                                  ProjectRepository $repository, ProjectInterface $project, IssueFactory $factory,
                                  UserInterface $user, IssueFormHandler $formHandler, IssueInterface $issue,
                                  Request $request, FormInterface $form, FormView $formView, TokenInterface $token,
                                  UrlGeneratorInterface $router)
    {
        $projectShortName = 'TEST';

        $container->get('kreta_core.repository.project')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(['shortName' => $projectShortName])->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('create_issue', $project)->shouldBeCalled()->willReturn(true);

        $container->get('kreta_core.factory.issue')->shouldBeCalled()->willReturn($factory);
        $this->getUserStub($container, $securityContext, $token, $user);
        $factory->create($project, $user)->shouldBeCalled()->willReturn($issue);

        $project->getParticipants()->shouldBeCalled()->willReturn([$user]);
        $container->get('kreta_web.form_handler.issue')->shouldBeCalled()->willReturn($formHandler);
        $formHandler->handleForm($request, $issue, ['participants' => [$user]])->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->get('router')->shouldBeCalled()->willReturn($router);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getShortName()->shouldBeCalled()->willReturn($projectShortName);
        $issue->getNumericId()->shouldBeCalled()->willReturn(42);
        $router->generate('kreta_web_issue_view', ['projectShortName' => $projectShortName, 'issueNumber' => 42], false)
            ->shouldBeCalled()->willReturn('/issues/TEST-42');

        $this->newAction($projectShortName, $request)
            ->shouldReturnAnInstanceOf('\Symfony\Component\HttpFoundation\RedirectResponse');
    }

    function it_denies_issue_creation(ContainerInterface $container, SecurityContextInterface $securityContext,
                                      ProjectRepository $repository, ProjectInterface $project, Request $request)
    {
        $projectShortName = 'TEST';

        $container->get('kreta_core.repository.project')->shouldBeCalled()->willReturn($repository);
        $repository->findOneBy(['shortName' => $projectShortName])->shouldBeCalled()->willReturn($project);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('create_issue', $project)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow('\Symfony\Component\Security\Core\Exception\AccessDeniedException')
            ->duringNewAction($projectShortName, $request);
    }

    function it_shows_edit_issue_form(ContainerInterface $container, SecurityContextInterface $securityContext,
                                      IssueRepository $repository, UserInterface $user, IssueFormHandler $formHandler,
                                      IssueInterface $issue, Request $request, FormInterface $form, FormView $formView,
                                      ProjectInterface $project)
    {
        $projectShortName = 'TEST';
        $issueNumber = 42;

        $container->get('kreta_core.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->findOneByShortCode($projectShortName, $issueNumber)->shouldBeCalled()->willReturn($issue);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $issue)->shouldBeCalled()->willReturn(true);

        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getParticipants()->shouldBeCalled()->willReturn([$user]);
        $container->get('kreta_web.form_handler.issue')->shouldBeCalled()->willReturn($formHandler);
        $formHandler->handleForm($request, $issue, ['participants' => [$user]])->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(false);
        $form->createView()->shouldBeCalled()->willReturn($formView);

        $this->editAction($projectShortName, $issueNumber, $request)
            ->shouldReturn(['form' => $formView, 'issue' => $issue]);
    }

    function it_edits_issue(ContainerInterface $container, SecurityContextInterface $securityContext,
                            IssueRepository $repository, ProjectInterface $project,
                            UserInterface $user, IssueFormHandler $formHandler, IssueInterface $issue,
                            Request $request, FormInterface $form, FormView $formView,
                            UrlGeneratorInterface $router)
    {
        $projectShortName = 'TEST';
        $issueNumber = 42;

        $container->get('kreta_core.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->findOneByShortCode($projectShortName, $issueNumber)->shouldBeCalled()->willReturn($issue);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $issue)->shouldBeCalled()->willReturn(true);

        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getParticipants()->shouldBeCalled()->willReturn([$user]);
        $container->get('kreta_web.form_handler.issue')->shouldBeCalled()->willReturn($formHandler);
        $formHandler->handleForm($request, $issue, ['participants' => [$user]])->shouldBeCalled()->willReturn($form);

        $form->isValid()->shouldBeCalled()->willReturn(true);
        $container->get('router')->shouldBeCalled()->willReturn($router);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getShortName()->shouldBeCalled()->willReturn($projectShortName);
        $issue->getNumericId()->shouldBeCalled()->willReturn($issueNumber);
        $router->generate('kreta_web_issue_view', [
            'projectShortName' => $projectShortName, 'issueNumber' => $issueNumber
        ], false)->shouldBeCalled()->willReturn('/issues/TEST-42');

        $this->editAction($projectShortName, $issueNumber, $request)
            ->shouldReturnAnInstanceOf('\Symfony\Component\HttpFoundation\RedirectResponse');
    }

    function it_shows_error_when_issue_not_found_editing (ContainerInterface $container, IssueRepository $repository,
                                                          Request $request)
    {
        $projectShortName = 'TEST';
        $issueNumber = 42;

        $container->get('kreta_core.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->findOneByShortCode($projectShortName, $issueNumber)->shouldBeCalled()->willReturn(null);

        $this->shouldThrow('\Symfony\Component\HttpKernel\Exception\NotFoundHttpException')
            ->duringEditAction($projectShortName, $issueNumber, $request);

    }

    function it_denies_issue_edition(ContainerInterface $container, SecurityContextInterface $securityContext,
                                      IssueRepository $repository, IssueInterface $issue, Request $request)
    {
        $projectShortName = 'TEST';
        $issueNumber = 42;

        $container->get('kreta_core.repository.issue')->shouldBeCalled()->willReturn($repository);
        $repository->findOneByShortCode($projectShortName, $issueNumber)->shouldBeCalled()->willReturn($issue);

        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted('edit', $issue)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow('\Symfony\Component\Security\Core\Exception\AccessDeniedException')
            ->duringEditAction($projectShortName, $issueNumber, $request);
    }

    protected function getUserStub(ContainerInterface $container, SecurityContextInterface $securityContext,
                                   TokenInterface $token, UserInterface $user)
    {
        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);
    }
}

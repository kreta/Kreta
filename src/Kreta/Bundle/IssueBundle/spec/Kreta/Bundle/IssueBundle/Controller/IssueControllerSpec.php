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

namespace spec\Kreta\Bundle\IssueBundle\Controller;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Issue\StateMachine\IssueStateMachine;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Kreta\Component\Workflow\Repository\StatusTransitionRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class IssueControllerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
        TokenStorageInterface $context,
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
        $paramFetcher->get('project')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('assignee')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('reporter')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('watcher')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('priority')->shouldBeCalled()->willReturn(2);
        $paramFetcher->get('status')->shouldBeCalled()->willReturn(2);
        $paramFetcher->get('label')->shouldBeCalled()->willReturn(1);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $issueRepository->findByParticipant(
            $user,
            [
                'title'  => 'title-filter',
                'p.id'   => 1,
                'a.id'   => 1,
                'rep.id' => 1,
                'w.id'   => 1,
                'pr.id'  => 2,
                's.id'   => 2,
                'l.id'   => 1
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
        TokenStorageInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
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
        TokenStorageInterface $context,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        TokenInterface $token,
        UserInterface $user,
        Request $request
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);

        $container->has('security.token_storage')->shouldBeCalled()->willReturn(true);
        $container->get('security.token_storage')->shouldBeCalled()->willReturn($context);

        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $projectRepository->findByParticipant($user)->shouldBeCalled()->willReturn([$project]);

        $container->get('kreta_issue.form_handler.issue')->shouldBeCalled()->willReturn($handler);
        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $handler->processForm(
            $request, $issue, ['method' => 'PUT', 'projects' => [$project]]
        )->shouldBeCalled()->willReturn($issue);

        $this->putIssuesAction($request, 'issue-id')->shouldReturn($issue);
    }

    function it_patches_issues_transition(
        Request $request,
        ParameterBag $bag,
        IssueInterface $issue,
        ProjectInterface $project,
        WorkflowInterface $workflow,
        ContainerInterface $container,
        StatusRepository $statusRepository,
        StatusTransitionRepository $statusTransitionRepository,
        StatusInterface $status,
        StatusTransitionInterface $statusTransition,
        IssueStateMachine $stateMachine,
        ManagerRegistry $managerRegistry,
        ObjectManager $manager
    )
    {
        $request->request = $bag;
        $bag->get('transition')->shouldBeCalled()->willReturn('transition-id');
        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getWorkflow()->shouldBeCalled()->willReturn($workflow);

        $container->get('kreta_workflow.repository.status')
            ->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findBy(['workflow' => $workflow])
            ->shouldBeCalled()->willReturn([$status]);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($statusTransitionRepository);
        $statusTransitionRepository->findBy(['workflow' => $workflow])
            ->shouldBeCalled()->willReturn([$statusTransition]);
        $statusTransitionRepository->find('transition-id')
            ->shouldBeCalled()->willReturn($statusTransition);

        $container->get('kreta_issue.state_machine.issue')->shouldBeCalled()->willReturn($stateMachine);
        $stateMachine->load($issue, [$status], [$statusTransition])->shouldBeCalled()->willReturn($stateMachine);
        $stateMachine->can($statusTransition)->shouldBeCalled()->willReturn(true);
        $statusTransition->getName()->shouldBeCalled()->willReturn('transition-name');
        $stateMachine->apply('transition-name')->shouldBeCalled();

        $container->has('doctrine')->shouldBeCalled()->willReturn(true);
        $container->get('doctrine')->shouldBeCalled()->willReturn($managerRegistry);
        $managerRegistry->getManager()->shouldBeCalled()->willReturn($manager);
        $manager->flush()->shouldBeCalled();

        $this->patchIssuesTransitionsAction($request, 'issue-id')->shouldReturn($issue);
    }

    function it_does_not_patch_issues_transition_because_the_transition_id_is_blank(Request $request, ParameterBag $bag)
    {
        $request->request = $bag;
        $bag->get('transition')->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new BadRequestHttpException('The transition id should not be blank'))
            ->during('patchIssuesTransitionsAction', [$request, 'issue-id']);
    }

    function it_does_not_patch_issues_transition_because_the_transition_is_invalid(
        Request $request,
        ParameterBag $bag,
        IssueInterface $issue,
        ProjectInterface $project,
        WorkflowInterface $workflow,
        ContainerInterface $container,
        StatusRepository $statusRepository,
        StatusTransitionRepository $statusTransitionRepository,
        StatusInterface $status,
        StatusTransitionInterface $statusTransition,
        IssueStateMachine $stateMachine
    )
    {
        $request->request = $bag;
        $bag->get('transition')->shouldBeCalled()->willReturn('transition-id');
        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getWorkflow()->shouldBeCalled()->willReturn($workflow);

        $container->get('kreta_workflow.repository.status')
            ->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->findBy(['workflow' => $workflow])
            ->shouldBeCalled()->willReturn([$status]);
        $container->get('kreta_workflow.repository.status_transition')
            ->shouldBeCalled()->willReturn($statusTransitionRepository);
        $statusTransitionRepository->findBy(['workflow' => $workflow])
            ->shouldBeCalled()->willReturn([$statusTransition]);
        $statusTransitionRepository->find('transition-id')
            ->shouldBeCalled()->willReturn($statusTransition);

        $container->get('kreta_issue.state_machine.issue')->shouldBeCalled()->willReturn($stateMachine);
        $stateMachine->load($issue, [$status], [$statusTransition])->shouldBeCalled()->willReturn($stateMachine);
        $stateMachine->can($statusTransition)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(new NotFoundHttpException('The requested transition cannot be applied'))
            ->during('patchIssuesTransitionsAction', [$request, 'issue-id']);
    }
}

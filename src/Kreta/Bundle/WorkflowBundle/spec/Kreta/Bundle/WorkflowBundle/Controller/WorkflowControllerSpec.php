<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WorkflowBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class WorkflowControllerSpec.
 *
 * @package spec\Kreta\Bundle\WorkflowBundle\Controller
 */
class WorkflowControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Controller\WorkflowController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_workflows(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user,
        ParamFetcher $paramFetcher,
        WorkflowInterface $workflow
    )
    {
        $container->get('kreta_workflow.repository.workflow')->shouldBeCalled()->willReturn($workflowRepository);

        $container->has('security.context')->shouldBeCalled()->willReturn(true);
        $container->get('security.context')->shouldBeCalled()->willReturn($context);
        $context->getToken()->shouldBeCalled()->willReturn($token);
        $token->getUser()->shouldBeCalled()->willReturn($user);

        $paramFetcher->get('sort')->shouldBeCalled()->willReturn('createdAt');
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $workflowRepository->findBy(['creator' => $user], ['createdAt' => 'ASC'], 10, 1)
            ->shouldBeCalled()->willReturn([$workflow]);

        $this->getWorkflowsAction($paramFetcher)->shouldReturn([$workflow]);
    }

    function it_gets_workflow(Request $request, WorkflowInterface $workflow)
    {
        $request->get('workflow')->shouldBeCalled()->willReturn($workflow);

        $this->getWorkflowAction($request, 'workflow-id')->shouldReturn($workflow);
    }

    function it_posts_workflow(
        ContainerInterface $container,
        Handler $handler,
        Request $request,
        WorkflowInterface $workflow
    )
    {
        $container->get('kreta_workflow.form_handler.workflow')->shouldBeCalled()->willReturn($handler);
        $handler->processForm($request)->shouldBeCalled()->willReturn($workflow);

        $this->postWorkflowAction($request)->shouldReturn($workflow);
    }

    function it_puts_workflow(
        ContainerInterface $container,
        Handler $handler,
        Request $request,
        WorkflowInterface $workflow
    )
    {
        $container->get('kreta_workflow.form_handler.workflow')->shouldBeCalled()->willReturn($handler);
        $request->get('workflow')->shouldBeCalled()->willReturn($workflow);
        $handler->processForm($request, $workflow, ['method' => 'PUT'])->shouldBeCalled()->willReturn($workflow);

        $this->putWorkflowAction($request, 'workflow-id')->shouldReturn($workflow);
    }
}

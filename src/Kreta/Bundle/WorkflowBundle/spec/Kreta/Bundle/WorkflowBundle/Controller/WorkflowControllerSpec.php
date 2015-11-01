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

namespace spec\Kreta\Bundle\WorkflowBundle\Controller;

use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
        WorkflowInterface $workflow
    )
    {
        $container->get('kreta_workflow.repository.workflow')->shouldBeCalled()->willReturn($workflowRepository);
        $workflowRepository->findAll()->shouldBeCalled()->willReturn([$workflow]);

        $this->getWorkflowsAction()->shouldReturn([$workflow]);
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

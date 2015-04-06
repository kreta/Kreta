<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\WorkflowBundle\Controller;

use Kreta\Component\Core\Exception\ResourceInUseException;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatusControllerSpec.
 *
 * @package spec\Kreta\Bundle\WorkflowBundle\Controller
 */
class StatusControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Controller\StatusController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_statuses(Request $request, WorkflowInterface $workflow, StatusInterface $status)
    {
        $request->get('workflow')->shouldBeCalled()->willReturn($workflow);
        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);

        $this->getStatusesAction($request, 'workflow-id')->shouldReturn([$status]);
    }

    function it_gets_status(ContainerInterface $container, StatusRepository $statusRepository, StatusInterface $status)
    {
        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('status-id', false)->shouldBeCalled()->willReturn($status);

        $this->getStatusAction('workflow-id', 'status-id')->shouldReturn($status);
    }

    function it_posts_status(
        ContainerInterface $container,
        Request $request,
        Handler $handler,
        StatusInterface $status,
        WorkflowInterface $workflow,
        Request $request
    )
    {
        $container->get('kreta_workflow.form_handler.status')->shouldBeCalled()->willReturn($handler);
        $request->get('workflow')->shouldBeCalled()->willReturn($workflow);
        $handler->processForm($request, null, ['workflow' => $workflow])->shouldBeCalled()->willReturn($status);

        $this->postStatusesAction($request, 'workflow-id')->shouldReturn($status);
    }

    function it_puts_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        Handler $handler
    )
    {
        $container->get('kreta_workflow.form_handler.status')->shouldBeCalled()->willReturn($handler);
        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('status-id', false)->shouldBeCalled()->willReturn($status);
        $handler->processForm($request, $status, ['method' => 'PUT'])->shouldBeCalled()->willReturn($status);

        $this->putStatusesAction($request, 'workflow-id', 'status-id')->shouldReturn($status);
    }

    function it_does_not_delete_status_because_the_status_is_in_use(
        ContainerInterface $container,
        StatusRepository $statusRepository,
        StatusInterface $status
    )
    {
        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('status-id', false)->shouldBeCalled()->willReturn($status);
        $status->isInUse()->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(new ResourceInUseException())->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_deletes_status(
        ContainerInterface $container,
        StatusRepository $statusRepository,
        StatusInterface $status
    )
    {
        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('status-id', false)->shouldBeCalled()->willReturn($status);
        $status->isInUse()->shouldBeCalled()->willReturn(false);

        $statusRepository->remove($status)->shouldBeCalled();

        $this->deleteStatusesAction('workflow-id', 'status-id');
    }
}

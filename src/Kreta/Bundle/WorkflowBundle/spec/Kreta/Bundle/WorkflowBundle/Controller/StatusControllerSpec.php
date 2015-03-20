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
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

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
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_does_not_get_statuses_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getStatusesAction', ['workflow-id']);
    }

    function it_gets_statuses(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusInterface $status
    )
    {
        $workflow = $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext);
        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);

        $this->getStatusesAction('workflow-id')->shouldReturn([$status]);
    }

    function it_does_not_get_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getStatusAction', ['workflow-id', 'status-id']);
    }

    function it_gets_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status
    )
    {
        $status = $this->getStatusIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, $statusRepository, $status
        );

        $this->getStatusAction('workflow-id', 'status-id')->shouldReturn($status);
    }

    function it_does_not_post_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('postStatusesAction', ['workflow-id']);
    }

    function it_posts_status(
        ContainerInterface $container,
        Request $request,
        Handler $handler,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        Request $request
    )
    {
        $workflow = $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status'
        );
        $container->get('kreta_workflow.form_handler.status')->shouldBeCalled()->willReturn($handler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, null, ['workflow' => $workflow])->shouldBeCalled()->willReturn($status);

        $this->postStatusesAction('workflow-id')->shouldReturn($status);
    }

    function it_does_not_put_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('putStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_puts_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        Handler $handler,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $status = $this->getStatusIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, $statusRepository, $status, 'manage_status'
        );
        $container->get('kreta_workflow.form_handler.status')->shouldBeCalled()->willReturn($handler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, $status, ['method' => 'PUT'])->shouldBeCalled()->willReturn($status);

        $this->putStatusesAction('workflow-id', 'status-id')->shouldReturn($status);
    }

    function it_does_not_delete_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_delete_status_because_the_status_is_in_use(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status
    )
    {
        $status = $this->getStatusIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, $statusRepository, $status, 'manage_status'
        );
        $status->isInUse()->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(new ResourceInUseException())->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_deletes_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status
    )
    {
        $status = $this->getStatusIfAllowedSpec(
            $container, $workflowRepository, $workflow, $securityContext, $statusRepository, $status, 'manage_status'
        );
        $status->isInUse()->shouldBeCalled()->willReturn(false);

        $statusRepository->remove($status)->shouldBeCalled();

        $this->deleteStatusesAction('workflow-id', 'status-id');
    }

    protected function getStatusIfAllowedSpec(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context,
        StatusRepository $statusRepository,
        $status = null,
        $grant = 'view',
        $result = true
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $context, $grant, $result);
        $container->get('kreta_workflow.repository.status')->shouldBeCalled()->willReturn($statusRepository);
        $statusRepository->find('status-id', false)->shouldBeCalled()->willReturn($status);

        return $status;
    }

    protected function getWorkflowIfAllowedSpec(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_workflow.repository.workflow')->shouldBeCalled()->willReturn($workflowRepository);
        $workflowRepository->find('workflow-id', false)->shouldBeCalled()->willReturn($workflow);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $workflow)->shouldBeCalled()->willReturn($result);

        return $workflow;
    }
}

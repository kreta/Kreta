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

use Kreta\Bundle\ApiBundle\Exception\ResourceInUseException;
use Kreta\Bundle\ApiBundle\Form\Handler\StatusHandler;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\StatusRepository;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use Prophecy\Argument;
use spec\Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestControllerSpec;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class StatusControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class StatusControllerSpec extends AbstractRestControllerSpec
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\StatusController');
    }

    function it_extends_abstract_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\Abstracts\AbstractRestController');
    }

    function it_does_not_get_statuses_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getStatusesAction', ['workflow-id']);
    }

    function it_gets_statuses(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusInterface $status
    )
    {
        $workflow = $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext);
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
        $this->getWorkflowIfAllowed($container, $workflowRepository, $workflow, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('getStatusAction', ['workflow-id', 'status-id']);
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
        $status = $this->getStatusIfAllowed(
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
        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('postStatusesAction', ['workflow-id']);
    }

    function it_posts_status(
        ContainerInterface $container,
        Request $request,
        StatusHandler $statusHandler,
        StatusInterface $status,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        Request $request
    )
    {
        $workflow = $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status'
        );
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $statusHandler->processForm($request, null, ['workflow' => $workflow])->shouldBeCalled()->willReturn($status);

        $this->postStatusesAction('workflow-id')->shouldReturn($status);
    }

    function it_does_not_put_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('putStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_puts_status(
        ContainerInterface $container,
        Request $request,
        StatusRepository $statusRepository,
        StatusInterface $status,
        StatusHandler $statusHandler,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $status = $this->getStatusIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $statusRepository, $status, 'manage_status'
        );
        $container->get('kreta_api.form_handler.status')->shouldBeCalled()->willReturn($statusHandler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $statusHandler->processForm($request, $status, ['method' => 'PUT'])->shouldBeCalled()->willReturn($status);

        $this->putStatusesAction('workflow-id', 'status-id')->shouldReturn($status);
    }

    function it_does_not_delete_status_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext
    )
    {
        $this->getWorkflowIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, 'manage_status', false
        );

        $this->shouldThrow(new AccessDeniedHttpException('Not allowed to access this resource'))
            ->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_does_not_delete_status_because_the_status_is_in_use(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        StatusRepository $statusRepository,
        StatusInterface $status,
        IssueRepository $issueRepository
    )
    {
        $status = $this->getStatusIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $statusRepository, $status, 'manage_status'
        );
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $issueRepository->isStatusInUse($workflow, $status)->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(new ResourceInUseException())->during('deleteStatusesAction', ['workflow-id', 'status-id']);
    }

    function it_deletes_status(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $securityContext,
        IssueRepository $issueRepository,
        StatusRepository $statusRepository,
        StatusInterface $status
    )
    {
        $status = $this->getStatusIfAllowed(
            $container, $workflowRepository, $workflow, $securityContext, $statusRepository, $status, 'manage_status'
        );
        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $status->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $issueRepository->isStatusInUse($workflow, $status)->shouldBeCalled()->willReturn(false);

        $statusRepository->remove($status)->shouldBeCalled();

        $this->deleteStatusesAction('workflow-id', 'status-id');
    }
}

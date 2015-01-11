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

use Kreta\Bundle\ApiBundle\spec\Kreta\Bundle\ApiBundle\Controller\BaseRestController;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class RestControllerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\Controller
 */
class RestControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\Controller\RestController');
    }

    function it_extends_fos_rest_controller()
    {
        $this->shouldHaveType('FOS\RestBundle\Controller\FOSRestController');
    }

    function it_does_not_get_user_because_it_is_not_an_instance_of_kreta_user(
        ContainerInterface $container,
        SecurityContextInterface $context,
        TokenInterface $token
    )
    {
        $this->getUserSpec($container, $context, $token);

        $this->shouldThrow(new AccessDeniedException())->during('getUser');
    }

    function it_gets_user(
        ContainerInterface $container,
        SecurityContextInterface $context,
        TokenInterface $token,
        UserInterface $user
    )
    {
        $this->getUserSpec($container, $context, $token, $user);
        
        $this->getUser()->shouldReturn($user);
    }

    function it_does_not_get_project_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $context
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $context, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getProjectIfAllowed', ['project-id']);
    }

    function it_gets_project(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $context
    )
    {
        $project = $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $context);

        $this->getProjectIfAllowed('project-id')->shouldReturn($project);
    }

    function it_does_not_get_workflow_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context
    )
    {
        $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $context, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getWorkflowIfAllowed', ['workflow-id']);
    }

    function it_gets_workflow(
        ContainerInterface $container,
        WorkflowRepository $workflowRepository,
        WorkflowInterface $workflow,
        SecurityContextInterface $context
    )
    {
        $workflow = $this->getWorkflowIfAllowedSpec($container, $workflowRepository, $workflow, $context);

        $this->getWorkflowIfAllowed('workflow-id')->shouldReturn($workflow);
    }

}

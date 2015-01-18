<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\spec\Kreta\Bundle\ApiBundle\Controller;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class BaseRestController.
 *
 * @package Kreta\Bundle\ApiBundle\spec\Kreta\Bundle\ApiBundle\Controller
 */
class BaseRestController extends ObjectBehavior
{
    protected function getProjectIfAllowedSpec(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        $grant = 'view',
        $result = true
    )
    {
        $container->get('kreta_project.repository.project')->shouldBeCalled()->willReturn($projectRepository);
        $projectRepository->find('project-id', false)->shouldBeCalled()->willReturn($project);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($grant, $project)->shouldBeCalled()->willReturn($result);

        return $project;
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

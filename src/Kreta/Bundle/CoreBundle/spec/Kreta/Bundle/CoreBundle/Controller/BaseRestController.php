<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\spec\Kreta\Bundle\CoreBundle\Controller;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class BaseRestController.
 *
 * @package Kreta\Bundle\CoreBundle\spec\Kreta\Bundle\CoreBundle\Controller
 */
class BaseRestController extends ObjectBehavior
{
    protected function getIssueIfAllowedSpec(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        SecurityContextInterface $securityContext,
        $issueGrant = 'view',
        $issueResult = true
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext);

        $container->get('kreta_issue.repository.issue')->shouldBeCalled()->willReturn($issueRepository);
        $issueRepository->find('issue-id', false)->shouldBeCalled()->willReturn($issue);
        $container->get('security.context')->shouldBeCalled()->willReturn($securityContext);
        $securityContext->isGranted($issueGrant, $issue)->shouldBeCalled()->willReturn($issueResult);

        return $issue;
    }

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
}

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Project\Model\Interfaces\IssueTypeInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\IssueTypeRepository;
use Kreta\Component\Project\Repository\ProjectRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class IssueTypeControllerSpec.
 *
 * @package spec\Kreta\Bundle\ProjectBundle\Controller
 */
class IssueTypeControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Controller\IssueTypeController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_gets_issue_types(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        IssueTypeRepository $issueTypeRepository,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $context,
        ProjectInterface $project,
        IssueTypeInterface $issueType
    )
    {
        $project = $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $context);

        $container->get('kreta_project.repository.issue_type')->shouldBeCalled()->willReturn($issueTypeRepository);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('Bug');
        $issueTypeRepository->findByProject($project, 10, 1, 'Bug')
            ->shouldBeCalled()->willReturn([$issueType]);

        $this->getIssueTypesAction('project-id', $paramFetcher)->shouldReturn([$issueType]);
    }

    function it_does_not_get_issue_types_because_the_user_has_not_the_required_grant(
        IssueTypeRepository $issueTypeRepository,
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        ParamFetcher $paramFetcher,
        SecurityContextInterface $securityContext
    )
    {
        $container->get('kreta_project.repository.issue_type')->shouldBeCalled()->willReturn($issueTypeRepository);
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'view', false);

        $this->shouldThrow(new AccessDeniedException())->during('getIssueTypesAction', ['project-id', $paramFetcher]);
    }

    function it_does_not_post_issue_type_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'create_issue_type', false
        );

        $this->shouldThrow(new AccessDeniedException())->during('postIssueTypesAction', ['project-id']);
    }

    function it_posts_issue_type(
        ContainerInterface $container,
        Request $request,
        ProjectRepository $projectRepository,
        SecurityContextInterface $securityContext,
        ProjectInterface $project,
        Request $request,
        Handler $handler,
        IssueTypeInterface $issueType
    )
    {
        $project = $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'create_issue_type'
        );

        $container->get('kreta_project.form_handler.issue_type')->shouldBeCalled()->willReturn($handler);
        $container->get('request')->shouldBeCalled()->willReturn($request);
        $handler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($issueType);

        $this->postIssueTypesAction('project-id')->shouldReturn($issueType);
    }

    function it_does_not_delete_issue_type_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getProjectIfAllowedSpec(
            $container, $projectRepository, $project, $securityContext, 'delete_issue_type', false
        );

        $this->shouldThrow(new AccessDeniedException())
            ->during('deleteIssueTypesAction', ['project-id', 'issue-type-id']);
    }

    function it_deletes_issue_type(
        ContainerInterface $container,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        IssueTypeRepository $issueTypeRepository,
        IssueTypeInterface $issueType
    )
    {
        $this->getProjectIfAllowedSpec($container, $projectRepository, $project, $securityContext, 'delete_issue_type');
        $container->get('kreta_project.repository.issue_type')->shouldBeCalled()->willReturn($issueTypeRepository);
        $issueTypeRepository->find('issue-type-id', false)->shouldBeCalled()->willReturn($issueType);
        $issueTypeRepository->remove($issueType)->shouldBeCalled();

        $this->deleteIssueTypesAction('project-id', 'issue-type-id');
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

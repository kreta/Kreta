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
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_issue_types(
        ContainerInterface $container,
        Request $request,
        IssueTypeRepository $issueTypeRepository,
        ParamFetcher $paramFetcher,
        ProjectInterface $project,
        IssueTypeInterface $issueType
    )
    {
        $container->get('kreta_project.repository.issue_type')->shouldBeCalled()->willReturn($issueTypeRepository);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('Bug');
        $issueTypeRepository->findByProject($project, 10, 1, 'Bug')->shouldBeCalled()->willReturn([$issueType]);

        $this->getIssueTypesAction($request, 'project-id', $paramFetcher)->shouldReturn([$issueType]);
    }

    function it_posts_issue_type(
        ContainerInterface $container,
        Request $request,
        ProjectInterface $project,
        Request $request,
        Handler $handler,
        IssueTypeInterface $issueType
    )
    {
        $container->get('kreta_project.form_handler.issue_type')->shouldBeCalled()->willReturn($handler);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $handler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($issueType);

        $this->postIssueTypesAction($request, 'project-id')->shouldReturn($issueType);
    }

    function it_deletes_issue_type(
        ContainerInterface $container,
        IssueTypeRepository $issueTypeRepository,
        IssueTypeInterface $issueType
    )
    {
        $container->get('kreta_project.repository.issue_type')->shouldBeCalled()->willReturn($issueTypeRepository);
        $issueTypeRepository->find('issue-type-id', false)->shouldBeCalled()->willReturn($issueType);
        $issueTypeRepository->remove($issueType)->shouldBeCalled();

        $this->deleteIssueTypesAction('project-id', 'issue-type-id');
    }
}

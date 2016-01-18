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

namespace spec\Kreta\Bundle\ProjectBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\IssuePriorityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IssuePriorityControllerSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class IssuePriorityControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\Controller\IssuePriorityController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_issue_priorities(
        ContainerInterface $container,
        Request $request,
        IssuePriorityRepository $repository,
        ParamFetcher $paramFetcher,
        ProjectInterface $project,
        IssuePriorityInterface $issuePriority
    )
    {
        $container->get('kreta_project.repository.issue_priority')->shouldBeCalled()->willReturn($repository);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $paramFetcher->get('limit')->shouldBeCalled()->willReturn(10);
        $paramFetcher->get('offset')->shouldBeCalled()->willReturn(1);
        $paramFetcher->get('q')->shouldBeCalled()->willReturn('Low');
        $repository->findByProject($project, 10, 1, 'Low')->shouldBeCalled()->willReturn([$issuePriority]);

        $this->getIssuePrioritiesAction($request, 'project-id', $paramFetcher)->shouldReturn([$issuePriority]);
    }

    function it_posts_issue_priority(
        ContainerInterface $container,
        Request $request,
        ProjectInterface $project,
        Request $request,
        Handler $handler,
        IssuePriorityInterface $issuePriority
    )
    {
        $container->get('kreta_project.form_handler.issue_priority')->shouldBeCalled()->willReturn($handler);
        $request->get('project')->shouldBeCalled()->willReturn($project);
        $handler->processForm($request, null, ['project' => $project])->shouldBeCalled()->willReturn($issuePriority);

        $this->postIssuePrioritiesAction($request, 'project-id')->shouldReturn($issuePriority);
    }

    function it_deletes_issue_priority(
        ContainerInterface $container,
        IssuePriorityRepository $repository,
        IssuePriorityInterface $issuePriority
    )
    {
        $container->get('kreta_project.repository.issue_priority')->shouldBeCalled()->willReturn($repository);
        $repository->find('issuePriority-id', false)->shouldBeCalled()->willReturn($issuePriority);
        $repository->remove($issuePriority)->shouldBeCalled();

        $this->deleteIssuePrioritiesAction('project-id', 'issuePriority-id');
    }
}

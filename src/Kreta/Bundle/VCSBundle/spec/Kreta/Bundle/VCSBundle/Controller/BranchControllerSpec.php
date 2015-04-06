<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\VCSBundle\Controller;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Repository\BranchRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BranchControllerSpec.
 *
 * @package spec\Kreta\Bundle\VCSBundle\Controller
 */
class BranchControllerSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\Controller\BranchController');
    }

    function it_extends_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function it_gets_branches(
        ContainerInterface $container,
        Request $request,
        BranchRepository $branchRepository,
        IssueInterface $issue,
        BranchInterface $branch
    )
    {
        $container->get('kreta_vcs.repository.branch')->shouldBeCalled()->willReturn($branchRepository);

        $request->get('issue')->shouldBeCalled()->willReturn($issue);
        $branchRepository->findByIssue($issue)->shouldBeCalled()->willReturn([$branch]);

        $this->getBranchesAction($request, 'issue-id')->shouldReturn([$branch]);
    }
}

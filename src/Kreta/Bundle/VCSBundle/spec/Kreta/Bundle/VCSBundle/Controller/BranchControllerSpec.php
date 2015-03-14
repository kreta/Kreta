<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\VCSBundle\Controller;

use Kreta\Bundle\CoreBundle\spec\Kreta\Bundle\CoreBundle\Controller\BaseRestController;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Issue\Repository\IssueRepository;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Repository\BranchRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class BranchControllerSpec.
 *
 * @package spec\Kreta\Bundle\VCSBundle\Controller
 */
class BranchControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\Controller\BranchController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_gets_branches(
        ContainerInterface $container,
        BranchRepository $branchRepository,
        IssueRepository $issueRepository,
        SecurityContextInterface $securityContext,
        IssueInterface $issue,
        BranchInterface $branch
    )
    {
        $issue = $this->getIssueIfAllowedSpec(
            $container, $issueRepository, $issue, $securityContext
        );
        $container->get('kreta_vcs.repository.branch')->shouldBeCalled()->willReturn($branchRepository);

        $branchRepository->findByIssue($issue)->shouldBeCalled()->willReturn([$branch]);

        $this->getBranchesAction('issue-id')->shouldReturn([$branch]);
    }
}

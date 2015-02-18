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
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Repository\ProjectRepository;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Kreta\Component\VCS\Repository\CommitRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class CommitControllerSpec.
 *
 * @package spec\Kreta\Bundle\VCSBundle\Controller
 */
class CommitControllerSpec extends BaseRestController
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\Controller\CommitController');
    }

    function it_extends_rest_controller()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Controller\RestController');
    }

    function it_does_not_get_commits_because_the_user_has_not_the_required_grant(
        ContainerInterface $container,
        IssueRepository $issueRepository,
        IssueInterface $issue,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext
    )
    {
        $this->getIssueIfAllowedSpec(
            $container, $projectRepository, $project, $issueRepository, $issue, $securityContext, 'view', false
        );
        $this->shouldThrow(new AccessDeniedException())->during('getCommitsAction', ['project-id', 'issue-id']);
    }

    function it_gets_commits(
        ContainerInterface $container,
        CommitRepository $commitRepository,
        IssueRepository $issueRepository,
        ProjectRepository $projectRepository,
        ProjectInterface $project,
        SecurityContextInterface $securityContext,
        IssueInterface $issue,
        CommitInterface $commit
    )
    {
        $issue = $this->getIssueIfAllowedSpec(
            $container, $projectRepository, $project, $issueRepository, $issue, $securityContext
        );
        $container->get('kreta_vcs.repository.commit')->shouldBeCalled()->willReturn($commitRepository);

        $commitRepository->findByIssue($issue)->shouldBeCalled()->willReturn([$commit]);

        $this->getCommitsAction('project-id', 'issue-id')->shouldReturn([$commit]);
    }
}

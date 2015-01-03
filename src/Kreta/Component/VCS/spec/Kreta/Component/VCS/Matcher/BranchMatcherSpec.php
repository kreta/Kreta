<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Matcher;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use Kreta\Component\VCS\Repository\IssueRepository;
use PhpSpec\ObjectBehavior;

class BranchMatcherSpec extends ObjectBehavior
{
    function let(IssueRepository $issueRepository)
    {
        $this->beConstructedWith($issueRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Matcher\BranchMatcher');
    }
    
    function it_gets_related_issues(BranchInterface $branch, IssueRepository $issueRepository,
                                    IssueInterface $issue, RepositoryInterface $repository, BranchInterface $branch)
    {
        $branch->getRepository()->shouldBeCalled()->willReturn($repository);
        $branch->getName()->shouldBeCalled()->willReturn('feature/PR0-1-test-relation-with-issues');

        $issueRepository->findRelatedIssuesByRepository($repository, 'PR0', '1')
            ->shouldBeCalled()->willReturn([$issue]);

        $this->getRelatedIssues($branch)->shouldReturn([$issue]);
    }
} 

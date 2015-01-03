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
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use Kreta\Component\VCS\Repository\IssueRepository;
use PhpSpec\ObjectBehavior;

class CommitMatcherSpec extends ObjectBehavior
{
    function let(IssueRepository $issueRepository)
    {
        $this->beConstructedWith($issueRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Matcher\CommitMatcher');
    }
    
    function it_gets_related_issues(CommitInterface $commit, IssueRepository $issueRepository,
                                    IssueInterface $issue, RepositoryInterface $repository, BranchInterface $branch)
    {
        $commit->getMessage()->shouldBeCalled()->willReturn('PR0-1 Testing relation with issue');
        $commit->getBranch()->shouldBeCalled()->willReturn($branch);
        $branch->getRepository()->shouldBeCalled()->willReturn($repository);
        $branch->getName()->shouldBeCalled()->willReturn('master');

        $issueRepository->findRelatedIssuesByRepository($repository, 'PR0', '1')
            ->shouldBeCalled()->willReturn([$issue]);

        $this->getRelatedIssues($commit)->shouldReturn([$issue]);
    }

    function it_matches_underscore_projects(CommitInterface $commit, IssueRepository $issueRepository,
                                            IssueInterface $issue, RepositoryInterface $repository, BranchInterface $branch)
    {
        $commit->getMessage()->shouldBeCalled()->willReturn('pr0-1 Testing relation with issue');
        $commit->getBranch()->shouldBeCalled()->willReturn($branch);
        $branch->getRepository()->shouldBeCalled()->willReturn($repository);
        $branch->getName()->shouldBeCalled()->willReturn('master');

        $issueRepository->findRelatedIssuesByRepository($repository, 'pr0', '1')
            ->shouldBeCalled()->willReturn([$issue]);

        $this->getRelatedIssues($commit)->shouldReturn([$issue]);
    }
} 

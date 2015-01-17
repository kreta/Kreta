<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\EventListener;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\VCS\Event\NewCommitEvent;
use Kreta\Component\VCS\Matcher\CommitMatcher;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use Kreta\Component\VCS\Repository\CommitRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CommitListenerSpec.
 *
 * @package spec\Kreta\Component\VCS\EventListener
 */
class CommitListenerSpec extends ObjectBehavior
{
    function let(CommitMatcher $matcher, CommitRepository $commitRepository)
    {
        $this->beConstructedWith($matcher, $commitRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\EventListener\CommitListener');
    }

    function it_listens_to_new_commit(
        CommitMatcher $matcher,
        CommitRepository $commitRepository,
        NewCommitEvent $event,
        CommitInterface $commit,
        IssueInterface $issue
    )
    {
        $event->getCommit()->shouldBeCalled()->willReturn($commit);

        $matcher->getRelatedIssues($commit)->shouldBeCalled()->willReturn([$issue]);
        $commit->setIssuesRelated([$issue])->shouldBeCalled();

        $commitRepository->persist($commit)->shouldBeCalled();

        $this->newCommit($event);
    }
}

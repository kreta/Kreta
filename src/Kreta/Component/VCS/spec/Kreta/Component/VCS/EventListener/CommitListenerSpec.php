<?php

namespace spec\Kreta\Component\VCS\EventListener;

use Doctrine\ORM\EntityManager;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\VCS\Event\NewCommitEvent;
use Kreta\Component\VCS\Matcher\CommitMatcher;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommitListenerSpec extends ObjectBehavior
{
    function let(CommitMatcher $matcher, EntityManager $manager)
    {
        $this->beConstructedWith($matcher, $manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\EventListener\CommitListener');
    }

    function it_listens_to_new_commit(CommitMatcher $matcher, EntityManager $manager, NewCommitEvent $event,
                                      CommitInterface $commit, IssueInterface $issue)
    {
        $event->getCommit()->shouldBeCalled()->willReturn($commit);

        $matcher->getRelatedIssues($commit)->shouldBeCalled()->willReturn([$issue]);
        $commit->setIssuesRelated([$issue])->shouldBeCalled();

        $manager->persist($commit)->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this->newCommit($event);
    }
}

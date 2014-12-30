<?php

namespace spec\Kreta\Component\VCS\Event;

use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewCommitEventSpec extends ObjectBehavior
{
    function let(CommitInterface $commit)
    {
        $this->beConstructedWith($commit);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Event\NewCommitEvent');
    }

    function it_gets_commit(CommitInterface $commit)
    {
        $this->getCommit()->shouldReturn($commit);
    }
}

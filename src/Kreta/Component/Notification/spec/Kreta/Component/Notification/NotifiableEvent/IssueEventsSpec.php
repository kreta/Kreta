<?php

namespace spec\Kreta\Component\Notification\NotifiableEvent;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Routing\RouterInterface;

class IssueEventsSpec extends ObjectBehavior
{
    function let(RouterInterface $router)
    {
        $this->beConstructedWith($router);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\NotifiableEvent\IssueEvents');
    }

    function it_supports_new_issue_events(IssueInterface $issue)
    {
        $this->supportsEvent('postPersist', $issue)->shouldReturn(true);
    }
}

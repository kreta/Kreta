<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\EventSubscriber;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kreta\Component\VCS\Event\NewBranchEvent;
use Kreta\Component\VCS\Event\NewCommitEvent;
use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use Kreta\Component\VCS\Model\Interfaces\CommitInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class DoctrineEventSubscriberSpec.
 *
 * @package spec\Kreta\Component\VCS\EventSubscriber
 */
class DoctrineEventSubscriberSpec extends ObjectBehavior
{
    function let(EventDispatcher $dispatcher)
    {
        $this->beConstructedWith($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\EventSubscriber\DoctrineEventSubscriber');
    }

    function it_implements_event_subscriber()
    {
        $this->shouldHaveType('Doctrine\Common\EventSubscriber');
    }

    function it_gets_subscribed_events()
    {
        $this->getSubscribedEvents()->shouldReturn([Events::postPersist]);
    }

    function it_dispatches_new_commit_event(
        EventDispatcher $dispatcher,
        LifecycleEventArgs $args,
        CommitInterface $commit
    )
    {
        $args->getObject()->shouldBeCalled()->willReturn($commit);
        $dispatcher->dispatch(NewCommitEvent::NAME, Argument::type('Kreta\Component\VCS\Event\NewCommitEvent'));

        $this->postPersist($args);
    }

    function it_dispatches_new_branch_event(
        EventDispatcher $dispatcher,
        LifecycleEventArgs $args,
        BranchInterface $branch
    )
    {
        $args->getObject()->shouldBeCalled()->willReturn($branch);
        $dispatcher->dispatch(NewBranchEvent::NAME, Argument::type('Kreta\Component\VCS\Event\NewBranchEvent'));

        $this->postPersist($args);
    }
}

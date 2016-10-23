<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spec\Kreta\SharedKernel\Infrastructure\Event\SimpleBus\EventRecorder\Doctrine\ORM;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Infrastructure\Event\SimpleBus\EventRecorder\Doctrine\ORM\AggregateRootEventRecorder;
use PhpSpec\ObjectBehavior;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;

class AggregateRootEventRecorderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AggregateRootEventRecorder::class);
        $this->shouldImplement(EventSubscriber::class);
        $this->shouldImplement(ContainsRecordedMessages::class);
    }

    function it_gets_subscribed_events()
    {
        $this->getSubscribedEvents()->shouldReturn([
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ]);
    }

    function it_post_persist(LifecycleEventArgs $event, AggregateRoot $aggregateRoot)
    {
        $event->getEntity()->shouldBeCalled()->willReturn($aggregateRoot);
        $aggregateRoot->recordedEvents()->shouldBeCalled()->willReturn([]);
        $aggregateRoot->clearEvents()->shouldBeCalled();
        $this->postPersist($event);
    }

    function it_post_update(LifecycleEventArgs $event, AggregateRoot $aggregateRoot)
    {
        $event->getEntity()->shouldBeCalled()->willReturn($aggregateRoot);
        $aggregateRoot->recordedEvents()->shouldBeCalled()->willReturn([]);
        $aggregateRoot->clearEvents()->shouldBeCalled();
        $this->postUpdate($event);
    }

    function it_post_remove(LifecycleEventArgs $event, AggregateRoot $aggregateRoot)
    {
        $event->getEntity()->shouldBeCalled()->willReturn($aggregateRoot);
        $aggregateRoot->recordedEvents()->shouldBeCalled()->willReturn([]);
        $aggregateRoot->clearEvents()->shouldBeCalled();
        $this->postRemove($event);
    }

    function it_manage_recorded_events(
        LifecycleEventArgs $event,
        AggregateRoot $aggregateRoot,
        DomainEvent $domainEvent
    ) {
        $event->getEntity()->shouldBeCalled()->willReturn($aggregateRoot);
        $aggregateRoot->recordedEvents()->shouldBeCalled()->willReturn([$domainEvent]);
        $aggregateRoot->clearEvents()->shouldBeCalled();
        $this->postPersist($event);
        $this->recordedMessages()->shouldBeArray();
        $this->recordedMessages()->shouldHaveCount(1);
        $this->eraseMessages();
        $this->recordedMessages()->shouldHaveCount(0);
    }
}

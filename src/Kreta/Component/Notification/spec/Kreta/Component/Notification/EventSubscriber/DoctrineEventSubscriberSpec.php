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

namespace spec\Kreta\Component\Notification\EventSubscriber;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;
use Kreta\Component\Notification\NotifiableEvent\Interfaces\NotifiableEventInterface;
use Kreta\Component\Notification\NotifiableEvent\Registry\Interfaces\NotifiableEventRegistryInterface;
use Kreta\Component\Notification\Notifier\Interfaces\NotifierInterface;
use Kreta\Component\Notification\Notifier\Registry\Interfaces\NotifierRegistryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

/**
 * Class DoctrineEventSubscriberSpec.
 *
 * @package spec\Kreta\Component\Notification\EventSubscriber
 */
class DoctrineEventSubscriberSpec extends ObjectBehavior
{
    function let(
        NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry
    )
    {
        $this->beConstructedWith($notifiableEventRegistry, $notifierRegistry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\EventSubscriber\DoctrineEventSubscriber');
    }

    function it_extends_kreta_abstract_event_subscriber()
    {
        $this->shouldHaveType('Kreta\Component\Notification\EventSubscriber\Abstracts\AbstractEventSubscriber');
    }

    function it_returns_subscribed_events()
    {
        $subscribedEvents = [
            Events::preRemove,
            Events::postRemove,
            Events::prePersist,
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate
        ];

        $this->getSubscribedEvents()->shouldReturn($subscribedEvents);
    }

    function it_handles_pre_remove(NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry,
        NotifiableEventInterface $notifiableEvent,
        NotifierInterface $notifier,
        NotificationInterface $notification,
        EntityManager $manager,
        LifecycleEventArgs $args)
    {
        $object = new stdClass();
        $this->handleEventConfig('preRemove', $object, $notifiableEventRegistry, $notifierRegistry, $notifiableEvent,
            $notifier, $notification);

        $args->getObject()->willReturn($object);
        $args->getObjectManager()->willReturn($manager);
        $this->preRemove($args);
    }

    function it_handles_post_remove(NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry,
        NotifiableEventInterface $notifiableEvent,
        NotifierInterface $notifier,
        NotificationInterface $notification,
        EntityManager $manager,
        LifecycleEventArgs $args)
    {
        $object = new stdClass();
        $this->handleEventConfig('postRemove', $object, $notifiableEventRegistry, $notifierRegistry, $notifiableEvent,
            $notifier, $notification);

        $args->getObject()->willReturn(new stdClass());
        $args->getObjectManager()->willReturn($manager);
        $this->postRemove($args);
    }

    function it_handles_pre_persist(NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry,
        NotifiableEventInterface $notifiableEvent,
        NotifierInterface $notifier,
        NotificationInterface $notification,
        EntityManager $manager,
        LifecycleEventArgs $args)
    {
        $object = new stdClass();
        $this->handleEventConfig('prePersist', $object, $notifiableEventRegistry, $notifierRegistry, $notifiableEvent,
            $notifier, $notification);

        $args->getObject()->willReturn(new stdClass());
        $args->getObjectManager()->willReturn($manager);
        $this->prePersist($args);
    }

    function it_handles_post_persist(NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry,
        NotifiableEventInterface $notifiableEvent,
        NotifierInterface $notifier,
        NotificationInterface $notification,
        EntityManager $manager,
        LifecycleEventArgs $args)
    {
        $object = new stdClass();
        $this->handleEventConfig('postPersist', $object, $notifiableEventRegistry, $notifierRegistry, $notifiableEvent,
            $notifier, $notification);

        $args->getObject()->willReturn(new stdClass());
        $args->getObjectManager()->willReturn($manager);
        $this->postPersist($args);
    }

    function it_handles_pre_update(NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry,
        NotifiableEventInterface $notifiableEvent,
        NotifierInterface $notifier,
        NotificationInterface $notification, EntityManager $manager,
        LifecycleEventArgs $args)
    {
        $object = new stdClass();
        $this->handleEventConfig('preUpdate', $object, $notifiableEventRegistry, $notifierRegistry, $notifiableEvent,
            $notifier, $notification);

        $args->getObject()->willReturn(new stdClass());
        $args->getObjectManager()->willReturn($manager);
        $this->preUpdate($args);
    }

    function it_handles_post_update(NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry,
        NotifiableEventInterface $notifiableEvent,
        NotifierInterface $notifier,
        NotificationInterface $notification, EntityManager $manager,
        LifecycleEventArgs $args)
    {
        $object = new stdClass();
        $this->handleEventConfig('postUpdate', $object, $notifiableEventRegistry, $notifierRegistry, $notifiableEvent,
            $notifier, $notification);

        $args->getObject()->willReturn(new stdClass());
        $args->getObjectManager()->willReturn($manager);
        $this->postUpdate($args);
    }

    private function handleEventConfig($event, $object,
        NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry,
        NotifiableEventInterface $notifiableEvent,
        NotifierInterface $notifier,
        NotificationInterface $notification)
    {
        $notifiableEvent->supportsEvent($event, Argument::any())->shouldBeCalled()->willReturn(true);
        $notifiableEvent->getNotifications($event, $object)->shouldBeCalled()->willReturn([$notification]);
        $notifiableEventRegistry->getNotifiableEvents()->willReturn([$notifiableEvent]);
        $notifier->notify($notification)->shouldBeCalled();
        $notifierRegistry->getNotifiers()->shouldBeCalled()->willReturn([$notifier]);
    }
}

<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\EventSubscriber\Abstracts;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Notification\NotifiableEvent\Registry\Interfaces\NotifiableEventRegistryInterface;
use Kreta\Component\Notification\Notifier\Registry\Interfaces\NotifierRegistryInterface;

/**
 * Abstract class AbstractEventSubscriber.
 *
 * @package Kreta\Component\Notification\EventSubscriber\Abstracts
 */
abstract class AbstractEventSubscriber
{
    /**
     * The notifiable event registry.
     *
     * @var \Kreta\Component\Notification\NotifiableEvent\Registry\Interfaces\NotifiableEventRegistryInterface
     */
    protected $notifiableEventRegistry;

    /**
     * The notifier registry.
     *
     * @var \Kreta\Component\Notification\Notifier\Registry\Interfaces\NotifierRegistryInterface
     */
    protected $notifierRegistry;

    /**
     * Builds the subscriber with the required dependencies. Both will be used in handleEvent method to notify users.
     *
     * @param NotifiableEventRegistryInterface $notifiableEventRegistry Registry containing all events to be notified
     * @param NotifierRegistryInterface        $notifierRegistry        Registry containing all notifiers enabled
     */
    public function __construct(
        NotifiableEventRegistryInterface $notifiableEventRegistry,
        NotifierRegistryInterface $notifierRegistry
    )
    {
        $this->notifiableEventRegistry = $notifiableEventRegistry;
        $this->notifierRegistry = $notifierRegistry;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    abstract public function getSubscribedEvents();

    /**
     * Handles the event for the object passed as parameter. It calls all subscribed notifiable events that will manage
     * the event and will call the registered notifiers to send notifications to users. Additionally, persists all
     * notification in database
     *
     * @param string                                     $event   Event that was triggered
     * @param object                                     $object  Object that triggered the event
     * @param \Doctrine\Common\Persistence\ObjectManager $manager Entity manager used to persist built in notification
     */
    public function handleEvent($event, $object, ObjectManager $manager = null)
    {
        $notifications = [];

        foreach ($this->notifiableEventRegistry->getNotifiableEvents() as $notifiable) {
            if ($notifiable->supportsEvent($event, $object)) {
                $notifications = array_merge($notifications, $notifiable->getNotifications($event, $object));
            }
        }

        foreach ($notifications as $notification) {
            foreach ($this->notifierRegistry->getNotifiers() as $notifier) {
                $notifier->notify($notification);
            }
            if ($manager) {
                $manager->persist($notification);
            }
        }

        if (count($notifications) > 0 && $manager) {
            $manager->flush();
        }
    }
}

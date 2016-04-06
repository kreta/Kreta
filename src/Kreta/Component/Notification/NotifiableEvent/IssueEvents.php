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

namespace Kreta\Component\Notification\NotifiableEvent;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Notification\Factory\NotificationFactory;
use Kreta\Component\Notification\NotifiableEvent\Interfaces\NotifiableEventInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class IssueEvents.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class IssueEvents implements NotifiableEventInterface
{
    const EVENT_ISSUE_NEW = 'issue_new';

    /**
     * Array which contains the supported events.
     *
     * @var array
     */
    protected $supportedEvents = ['postPersist'];

    /**
     * The notification factory.
     *
     * @var \Kreta\Component\Notification\Factory\NotificationFactory
     */
    protected $notificationFactory;

    /**
     * The router.
     *
     * @var \Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * Constructor.
     *
     * @param \Kreta\Component\Notification\Factory\NotificationFactory $notificationFactory The notification factory
     * @param \Symfony\Component\Routing\RouterInterface                $router              The router
     */
    public function __construct(NotificationFactory $notificationFactory, RouterInterface $router)
    {
        $this->notificationFactory = $notificationFactory;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEvent($event, $object)
    {
        return $object instanceof IssueInterface && in_array($event, $this->supportedEvents, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifications($event, $object)
    {
        $notifications = [];
        switch ($event) {
            case 'postPersist':
                if ($object->getAssignee() !== $object->getReporter()) {
                    $url = $this->router->generate(
                        'get_issue', ['issueId' => $object->getId()]
                    );
                    $notification = $this->notificationFactory->create();
                    $notification
                        ->setProject($object->getProject())
                        ->setTitle($object->getTitle())
                        ->setDescription($object->getDescription())
                        ->setType(self::EVENT_ISSUE_NEW)
                        ->setResourceUrl($url)
                        ->setWebUrl($url)
                        ->setUser($object->getAssignee());
                    $notifications[] = $notification;
                }
                break;
        }

        return $notifications;
    }
}

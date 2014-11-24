<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\NotifiableEvent;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Notification\Factory\NotificationFactory;
use Kreta\Component\Notification\NotifiableEvent\NotifiableEventInterface;
use Kreta\Component\Notification\Model\Notification;
use Symfony\Component\Routing\RouterInterface;

class IssueEvents implements NotifiableEventInterface
{
    protected $supportedEvents = array('postPersist');

    protected $router;

    const EVENT_ISSUE_NEW = 'issue_new';

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @{@inheritdoc}
     */
    public function supportsEvent($event, $object)
    {
        return $object instanceof IssueInterface && in_array($event, $this->supportedEvents);
    }

    /**
     * @{@inheritdoc}
     */
    public function getNotifications($event, $object)
    {
        $notifications = array();
        switch ($event) {
            case 'postPersist':
                //Notify to assignee that has a new issue
                if ($object->getAssignee() != $object->getReporter()) {
                    $notification = new Notification();
                    $url = $this->router->generate(
                        'kreta_web_issue_view', [
                            'projectShortName' => $object->getProject()->getShortName(),
                            'issueNumber' => $object->getNumericId()
                        ]
                    );
                    $notification
                        ->setDate(new \DateTime())
                        ->setProject($object->getProject())
                        ->setTitle($object->getTitle())
                        ->setDescription($object->getDescription())
                        ->setType(self::EVENT_ISSUE_NEW)
                        ->setRead(false)
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

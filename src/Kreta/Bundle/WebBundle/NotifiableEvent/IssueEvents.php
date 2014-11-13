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
use Kreta\Component\Notification\NotifiableEvent\NotifiableEventInterface;
use Kreta\Component\Notification\Model\Notification;

class IssueEvents implements NotifiableEventInterface
{
    protected $supportedEvents = array('postPersist');

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
        switch($event) {
            case 'postPersist':
                //Notify to assignee that has a new notification
                if($object->getAssignee() != $object->getReporter()) {
                    $notification = new Notification();
                    $notification->setDate(new \DateTime())
                        ->setProject($object->getProject())
                        ->setTitle('New issue: '. $object->getTitle())
                        ->setDescription($object->getDescription())
                        ->setRead(false)
                        ->setUser($object->getAssignee());
                    $notifications[] = $notification;
                }
                break;
        }

        return $notifications;
    }

} 

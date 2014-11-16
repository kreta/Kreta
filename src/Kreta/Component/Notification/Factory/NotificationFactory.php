<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Factory;

use Kreta\Component\Core\Factory\BaseFactory;
use Kreta\Component\Notification\Model\Interfaces\NotificationInterface;

/**
 * Class NotificationFactory
 *
 * @package Kreta\Component\Notification\Factory
 */
class NotificationFactory extends BaseFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        /** @var NotificationInterface $notification */
        $notification = new $this->className;
        $notification->setDate(new \DateTime());
        $notification->setRead(false);

        return $notification;
    }
}

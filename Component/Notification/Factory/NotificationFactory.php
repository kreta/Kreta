<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Factory;

/**
 * Class NotificationFactory.
 *
 * @package Kreta\Component\Notification\Factory
 */
class NotificationFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of a notification.
     *
     * @return \Kreta\Component\Notification\Model\Interfaces\NotificationInterface
     */
    public function create()
    {
        $notification = new $this->className;

        return $notification
            ->setDate(new \DateTime())
            ->setRead(false);
    }
}

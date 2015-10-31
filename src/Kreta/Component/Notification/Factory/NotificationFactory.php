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

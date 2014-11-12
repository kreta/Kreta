<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\NotifiableEvent\Registry;

/**
 * Class NonExistingNotifierException
 *
 * @package Kreta\Component\Notification\Notifier\Registry
 */
class ExistingNotifiableEventException extends \InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct(sprintf('Notifiable event with name "%s" already exists', $name));
    }
}

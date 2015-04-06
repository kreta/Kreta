<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Notification\Notifier\Registry;

/**
 * Class NonExistingNotifierException.
 *
 * @package Kreta\Component\Notification\Notifier\Registry
 */
class ExistingNotifierException extends \InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $name The name
     */
    public function __construct($name)
    {
        parent::__construct(sprintf('Notifier with name "%s" already exists', $name));
    }
}

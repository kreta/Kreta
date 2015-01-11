<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class FormHandlerEvent.
 *
 * @package Kreta\Bundle\CoreBundle\Event
 */
class FormHandlerEvent extends Event
{
    const NAME = 'kreta_core_event_form_handler';

    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'error';

    /**
     * Event type.
     *
     * @var string
     */
    protected $type;

    /**
     * Event message.
     *
     * @var string
     */
    protected $message;

    /**
     * Creates a form handler event.
     *
     * @param string $type    Event type, use FormHandlerEvent::TYPE_* constants
     * @param string $message Message to be displayed to the user
     */
    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Gets type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets type. Use FormHandlerEvent::TYPE_* constants
     *
     * @param string $type The type to be set
     *
     * @return $this self Object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets message.
     *
     * @param string $message The message to be set
     *
     * @return $this self Object
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}

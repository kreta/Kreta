<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class FormHandlerEvent extends Event
{
    const NAME = 'kreta_web_event_form_handler';

    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'error';

    protected $type;

    protected $message;

    public function __construct($type, $message)
    {
        $this->$type;
        $this->$message;
    }

    /**
     * Returns type
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets type
     *
     * @param mixed $type The type to be set
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Returns message
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets message
     *
     * @param mixed $message The message to be set
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }


} 

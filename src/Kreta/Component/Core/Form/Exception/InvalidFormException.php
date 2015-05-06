<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Form\Exception;

/**
 * Class InvalidFormException.
 *
 * @package Kreta\Component\Core\Form\Exception
 */
class InvalidFormException extends \Exception
{
    /**
     * Array which contains the form errors.
     *
     * @var array
     */
    protected $formErrors;

    /**
     * Constructor.
     *
     * @param array $formErrors Array which contains the form errors
     */
    public function __construct(array $formErrors = [])
    {
        $this->formErrors = $formErrors;
        parent::__construct('Invalid form');
    }

    /**
     * Gets form errors.
     *
     * @return array
     */
    public function getFormErrors()
    {
        return $this->formErrors;
    }
}

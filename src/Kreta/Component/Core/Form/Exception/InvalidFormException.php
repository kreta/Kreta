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

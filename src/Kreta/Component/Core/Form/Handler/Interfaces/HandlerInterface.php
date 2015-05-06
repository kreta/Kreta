<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Form\Handler\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface HandlerInterface.
 *
 * @package Kreta\Component\Core\Form\Handler\Interfaces
 */
interface HandlerInterface
{
    /**
     * Wrapper which envelops all the logic that has the form process returning
     * the proper data. All the process can be changed extending it.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     Contains values sent by the user
     * @param Object|null                               $object      The object to be edited with form content
     * @param array                                     $formOptions Array which contains the options that will be
     *                                                               passed in the form create method
     *
     * @return mixed
     * @throws \Kreta\Component\Core\Form\Exception\InvalidFormException
     */
    public function processForm(Request $request, $object = null, array $formOptions = []);

    /**
     * Handles the form and saves the object to the DB. All process can be changed extending
     * handleFiles and handleObject methods. See each methods doc for more info.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     Contains values sent by the user
     * @param Object|null                               $object      The object to be edited with form content
     * @param array                                     $formOptions Array which contains the options that will be
     *                                                               passed in the form create method
     *
     * @return \Symfony\Component\Form\FormInterface
     * @throws \Kreta\Component\Core\Form\Exception\InvalidFormException
     */
    public function handleForm(Request $request, $object = null, array $formOptions = []);
}

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

namespace Kreta\Component\Core\Form\Handler\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface HandlerInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface HandlerInterface
{
    /**
     * Wrapper which envelops all the logic that has the form process returning
     * the proper data. All the process can be changed extending it.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     Contains values sent by the user
     * @param object|null                               $object      The object to be edited with form content
     * @param array                                     $formOptions Array which contains the options that will be
     *                                                               passed in the form create method
     *
     * @throws \Kreta\Component\Core\Form\Exception\InvalidFormException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     *
     * @return mixed
     */
    public function processForm(Request $request, $object = null, array $formOptions = []);

    /**
     * Handles the form and saves the object to the DB. All process can be changed extending
     * handleFiles and handleObject methods. See each methods doc for more info.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     Contains values sent by the user
     * @param object|null                               $object      The object to be edited with form content
     * @param array                                     $formOptions Array which contains the options that will be
     *                                                               passed in the form create method
     *
     * @throws \Kreta\Component\Core\Form\Exception\InvalidFormException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function handleForm(Request $request, $object = null, array $formOptions = []);

    /**
     * Creates a form with the given parameters.
     *
     * To simplify the request body parameters, the form name
     * is setting to '' when the form is going to be create.
     *
     * @param object|null $object      Model related to the form
     * @param array       $formOptions Array which contains the options that will be passed
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm($object = null, array $formOptions = []);
}

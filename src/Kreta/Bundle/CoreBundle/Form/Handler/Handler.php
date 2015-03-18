<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Handler\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Handler.
 *
 * @package Kreta\Bundle\CoreBundle\Form\Handler
 */
class Handler
{
    /**
     * The factory used to create a new Form instance.
     *
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * The name of the form.
     *
     * @var string
     */
    protected $formName;

    /**
     * Manager used to persist and flush the object.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory        $formFactory Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager $manager     Persists and flush the object
     * @param string                                     $formName    The name of the form
     */
    public function __construct(FormFactory $formFactory, ObjectManager $manager, $formName = 'form')
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->formName = $formName;
    }

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
     * @throws \Kreta\Bundle\CoreBundle\Form\Handler\Exception\InvalidFormException
     */
    public function processForm(Request $request, $object = null, array $formOptions = [])
    {
        $form = $this->handleForm($request, $object, $formOptions);

        return !$object ? $form->getData() : $object;
    }

    /**
     * Handles the form and saves the object to the DB. All process can be changed extending
     * handleFiles and handleObject methods. See each methods doc for more info.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     Contains values sent by the user
     * @param Object|null                               $object      The object to be edited with form content
     * @param array                                     $formOptions Array which contains the options that will be
     *                                                               passed in the form create method
     *
     * @return \Symfony\Component\Form\Form
     * @throws \Kreta\Bundle\CoreBundle\Form\Handler\Exception\InvalidFormException
     */
    public function handleForm(Request $request, $object = null, array $formOptions = [])
    {
        $form = $this->createForm($object, $formOptions);
        if ($request->isMethod('POST') || $request->isMethod('PUT')) {
            $form->handleRequest($request);
            if (!$form->isValid()) {
                throw new InvalidFormException($this->getFormErrors($form));
            }

            if (!$object) {
                $object = $form->getData();
            }
            $this->handleFiles($request->files, $object);
            $this->handleObject($object);
        }

        return $form;
    }

    /**
     * Creates a form with the given parameters.
     *
     * To simplify the request body parameters, the form name
     * is setting to '' when the form is going to be create.
     *
     * @param Object|null $object      Model related to the form
     * @param array       $formOptions Array which contains the options that will be passed
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        return $this->formFactory->createNamedBuilder('', $this->formName, $object, $formOptions)->getForm();
    }

    /**
     * Handles file upload.
     *
     * @param FileBag $files  Files found in current request
     * @param Object  $object Object been handled in the request
     *
     * @return void
     */
    protected function handleFiles(FileBag $files, $object)
    {
    }

    /**
     * Edits (if needed), persists and flushes the object.
     *
     * @param Object $object The object to be handled
     *
     * @return void
     */
    protected function handleObject($object)
    {
        $this->manager->persist($object);
        $this->manager->flush();
    }

    /**
     * Returns all the errors from form into array.
     *
     * @param \Symfony\Component\Form\FormInterface $form The form
     *
     * @return array
     */
    protected function getFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }
}

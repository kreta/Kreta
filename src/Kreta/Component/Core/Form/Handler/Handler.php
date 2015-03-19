<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Form\Exception\InvalidFormException;
use Kreta\Component\Core\Form\Handler\Interfaces\HandlerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Handler.
 *
 * @package Kreta\Component\Core\Form\Handler
 */
class Handler implements HandlerInterface
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
     * {@inheritdoc}
     */
    public function processForm(Request $request, $object = null, array $formOptions = [])
    {
        $form = $this->handleForm($request, $object, $formOptions);

        return !$object ? $form->getData() : $object;
    }

    /**
     * {@inheritdoc}
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

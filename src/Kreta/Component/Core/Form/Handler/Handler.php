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

namespace Kreta\Component\Core\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Form\Exception\InvalidFormException;
use Kreta\Component\Core\Form\Handler\Interfaces\HandlerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Handler.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Handler implements HandlerInterface
{
    /**
     * The factory used to create a new Form instance.
     *
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $formFactory;

    /**
     * The fully qualified namespace class of the form type.
     *
     * @var string
     */
    protected $fqcn;

    /**
     * Manager used to persist and flush the object.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactoryInterface $formFactory Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager   $manager     Persists and flush the object
     * @param string                                       $fqcn        The fully qualified namespace class of the form
     */
    public function __construct(FormFactoryInterface $formFactory, ObjectManager $manager, $fqcn = 'form')
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->fqcn = $fqcn;
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
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
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
     * {@inheritdoc}
     */
    public function createForm($object = null, array $formOptions = [])
    {
        return $this->formFactory->createNamedBuilder('', $this->fqcn, $object, $formOptions)->getForm();
    }

    /**
     * Handles file upload.
     *
     * @param \Symfony\Component\HttpFoundation\FileBag $files  Files found in current request
     * @param Object                                    $object Object been handled in the request
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

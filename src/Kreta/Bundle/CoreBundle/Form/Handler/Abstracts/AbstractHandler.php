<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Form\Handler\Abstracts;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\WebBundle\Event\FormHandlerEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractHandler.
 *
 * @package Kreta\Bundle\CoreBundle\Form\Handler\Abstracts
 */
abstract class AbstractHandler
{
    /**
     * The factory used to create a new Form instance.
     *
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * Manager used to persist and flush the object.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Dispatcher used to dispatch FormHandlerEvents.
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Dispatched default success message.
     *
     * @var string
     */
    protected $successMessage = 'Saved successfully';

    /**
     * Dispatched default error message.
     *
     * @var string
     */
    protected $errorMessage = 'Error while saving';

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         Persists and flush the object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher Dispatches FormHandlerEvents
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Handles the form and saves the object to the DB. All process can be changed extending handleFiles,
     * handleObject dispatchSuccess and dispatchError methods. See each methods doc for more info.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     Contains values sent by the user
     * @param Object|null                               $object      The object to be edited with form content
     * @param array                                     $formOptions Array which contains the options that will be
     *                                                               passed in the form create method
     *
     * @return \Symfony\Component\Form\Form
     */
    public function handleForm(Request $request, $object = null, array $formOptions = [])
    {
        $form = $this->createForm($object, $formOptions);
        if ($request->isMethod('POST') || $request->isMethod('PUT')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!$object) {
                    $object = $form->getData();
                }
                $this->handleFiles($request->files, $object);
                $this->handleObject($object);
                $this->dispatchSuccess();
            } else {
                $this->dispatchError();
            }
        }

        return $form;
    }

    /**
     * Creates a form with the given parameters.
     *
     * @param Object|null $object      Model related to the form
     * @param array       $formOptions Array which contains the options that will be passed in the form create method
     *
     * @return \Symfony\Component\Form\Form
     */
    abstract protected function createForm($object = null, array $formOptions = []);

    /**
     * Handles file upload.
     *
     * For extended functionality override the method.
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
     * For extended functionality override the method.
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
     * Dispatches success event. By default it uses $successMessage for the message.
     */
    protected function dispatchSuccess()
    {
        $this->eventDispatcher->dispatch(
            FormHandlerEvent::NAME,
            new FormHandlerEvent(FormHandlerEvent::TYPE_SUCCESS, $this->successMessage)
        );
    }

    /**
     * Dispatches error event. By default it uses $errorMessage for the message.
     */
    protected function dispatchError()
    {
        $this->eventDispatcher->dispatch(
            FormHandlerEvent::NAME,
            new FormHandlerEvent(FormHandlerEvent::TYPE_ERROR, $this->errorMessage)
        );
    }
}

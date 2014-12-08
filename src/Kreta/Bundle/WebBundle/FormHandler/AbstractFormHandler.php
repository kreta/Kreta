<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\FormHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\WebBundle\Event\FormHandlerEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractFormHandler
 *
 * @package Kreta\Bundle\WebBundle\FormHandler
 */
abstract class AbstractFormHandler
{
    /**
     * The factory used to create a new Form instance.
     *
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * Manager used to persist and flush the object.
     *
     * @var ObjectManager
     */
    protected $manager;

    /**
     * Dispatcher used to dispatch FormHandlerEvents.
     *
     * @var EventDispatcherInterface
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
     * Creates a form handler
     *
     * @param FormFactory     $formFactory     Used to create a new Form instance.
     * @param ObjectManager   $manager         Used to persist and flush the object.
     * @param EventDispatcherInterface $eventDispatcher Used to dispatch FormHandlerEvents.
     */
    public function __construct(FormFactory $formFactory, ObjectManager $manager,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Handles the form and saves the object to the DB. All process can be changed extendind handleFiles, handleObject
     * dispatchSuccess and dispatchError methods. See each methods doc for more info.
     *
     * @param Request $request     Contains values sent by the user.
     * @param object  $object      The object to be edited with form content.
     * @param null    $formOptions Options that will be passed as parameter to createForm method.
     *
     * @return \Symfony\Component\Form\Form
     */
    public function handleForm(Request $request, $object, $formOptions = null)
    {
        $form = $this->createForm($object, $formOptions);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
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
     * @param object        $object      Model related to the form.
     * @param object | null $formOptions Options that will be passed in the form create method.
     *
     * @return \Symfony\Component\Form\Form
     */
    abstract protected function createForm($object, $formOptions = null);

    /**
     * Handles file upload.
     *
     * For extended functionality override the method.
     *
     * @param FileBag $files  Files found in current request.
     * @param         $object Object been handled in the request.
     */
    protected function handleFiles(FileBag $files, $object)
    {
    }

    /**
     * Edits (if needed), persists and flushes the object.
     *
     * For extended functionality override the method.
     *
     * @param object $object The object to be handled.
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

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
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractFormHandler
{
    protected $formFactory;

    protected $manager;

    protected $eventDispatcher;

    public function __construct(FormFactory $formFactory, ObjectManager $manager, EventDispatcher $eventDispatcher)
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Request $request
     * @param         $object
     * @param array   $helpers
     * @param null    $formOptions
     *
     * @return \Symfony\Component\Form\Form
     */
    public function handleForm(Request $request, $object, $helpers = [], $formOptions = null)
    {
        $form = $this->createForm($object, $formOptions);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->handleObject($object, $helpers);
                $this->dispatchSuccess();
            } else {
                $this->dispatchError();
            }
        }

        return $form;
    }

    /**
     * @param $object
     * @param $formOptions
     *
     * @return \Symfony\Component\Form\Form
     */
    abstract protected function createForm($object, $formOptions = null);

    protected function handleObject($object, $helpers = [])
    {
        $this->manager->persist($object);
        $this->manager->flush();
    }

    protected function dispatchSuccess()
    {
        $this->eventDispatcher->dispatch(
            FormHandlerEvent::NAME,
            new FormHandlerEvent(FormHandlerEvent::TYPE_SUCCESS, 'Saved successfully')
        );
    }

    protected function dispatchError()
    {
        $this->eventDispatcher->dispatch(
            FormHandlerEvent::NAME,
            new FormHandlerEvent(FormHandlerEvent::TYPE_ERROR, 'Error while saving')
        );
    }
}

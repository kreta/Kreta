<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseRegistrationController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RegistrationController.
 *
 * @package Kreta\Bundle\UserBundle\Controller
 */
class RegistrationController extends BaseRegistrationController
{
    /**
     * {@inheritdoc}
     */
    public function registerAction(Request $request)
    {
        $criteria = ['confirmationToken' => $request->query->get('token')];
        if ('POST' === $request->getMethod()) {
            $criteria = ['email' => $request->query->get('email')];
        }
        if (false !== array_search(null, $criteria)) {
            throw new NotFoundHttpException();
        }
        $user = $this->get('kreta_user.repository.user')->findOneBy($criteria, false);
        $form = $this->get('kreta_user.form_handler.registration')->createForm($user);
        $form->setData($user);
        $form->handleRequest($request);

        return $form->isValid()
            ? $this->manageValidForm($request, $form, $user)
            : $this->render('FOSUserBundle:Registration:register.html.twig',
                ['form' => $form->createView(), 'user' => $user]
            );
    }

    /**
     * Manages the part of action when the form is valid.
     *
     * @param \Symfony\Component\HttpFoundation\Request            $request The request
     * @param \Symfony\Component\Form\FormInterface                $form    The form
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user    The user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function manageValidForm(Request $request, FormInterface $form, UserInterface $user)
    {
        $user->setEnabled(true);
        $user->setConfirmationToken(null);

        $dispatcher = $this->get('event_dispatcher');

        $event = new FilterUserResponseEvent($user, $request, new Response());
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, new FormEvent($form, $request));
        $this->get('fos_user.user_manager')->updateUser($user);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, $event);

        if (!($this->getUser() instanceof UserInterface)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $dispatcher->dispatch(AuthorizationEvent::NAME, new AuthorizationEvent($request));

        return $this->redirect($this->generateUrl('kreta_web_homepage'));
    }
}

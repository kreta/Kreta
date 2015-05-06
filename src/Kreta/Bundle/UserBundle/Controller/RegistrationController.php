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
use Kreta\Bundle\UserBundle\Event\AuthorizationEvent;
use Kreta\Component\User\Model\Interfaces\UserInterface;
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
    public function confirmedAction()
    {
        if (!($this->getUser() instanceof UserInterface)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $this->get('event_dispatcher')->dispatch(
            AuthorizationEvent::NAME, new AuthorizationEvent($this->get('request'))
        );

        return $this->redirect($this->generateUrl('kreta_web_homepage'));
    }
}

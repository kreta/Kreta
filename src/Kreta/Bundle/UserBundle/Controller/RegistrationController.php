<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseRegistrationController;
use Kreta\Bundle\CoreBundle\Event\AuthorizationEvent;
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
        $user = $this->getUser();
        if (!($user instanceof UserInterface)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = $this->get('event_dispatcher')->dispatch(
            AuthorizationEvent::NAME, new AuthorizationEvent($user, $this->get('request'))
        );

        return $this->render(
            'FOSUserBundle:Registration:confirmed.html.twig', ['user' => $user], $event->getResponse()
        );
    }
}

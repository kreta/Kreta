<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Mailer;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\Mailer as BaseMailer;

/**
 * Class Mailer.
 *
 * @package Kreta\Bundle\UserBundle\Mailer
 */
class Mailer extends BaseMailer
{
    const KRETA_INVITATION_EMAIL = 'invitations@kreta.io';

    /**
     * {@inheritdoc}
     */
    public function sendInvitationEmail(UserInterface $user)
    {
        $template = $this->parameters['invitation.template'];
        $url = $this->router->generate('kreta_user_registration', ['token' => $user->getConfirmationToken()], true);
        $rendered = $this->templating->render($template, ['user' => $user, 'registerUrl' => $url]);
        $this->sendEmailMessage($rendered, self::KRETA_INVITATION_EMAIL, $user->getEmail());
    }
}

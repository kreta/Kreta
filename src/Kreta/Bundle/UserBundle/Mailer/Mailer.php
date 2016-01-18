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

namespace Kreta\Bundle\UserBundle\Mailer;

use FOS\UserBundle\Mailer\Mailer as BaseMailer;
use FOS\UserBundle\Model\UserInterface;

/**
 * Class Mailer.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
